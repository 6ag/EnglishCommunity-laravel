<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Comment;
use App\Http\Model\Trends;
use App\Http\Model\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Http\Requests;

class TrendsController extends BaseController
{
    /**
     * @api {get} /getTrendsList.api 动弹列表
     * @apiDescription 获取动弹列表,可根据参数返回不同的数据
     * @apiGroup Trends
     * @apiPermission none
     * @apiParam {String} type 返回类型 new最新 hot热门 me我的
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiParam {Number} [user_id] 如果type是me,这个字段一定传
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询动弹列表成功",
     *           "data": {
     *           "total": 4,
     *           "rows": "2",
     *           "current_page": 1,
     *           "data": [
     *               {
     *               "id": 4,
     *               "user_id": 3,
     *               "content": "吃屎的这么这么多",
     *               "photo": null,
     *               "view": 15,
     *               "created_at": "2016-08-08 15:57:08",
     *               "updated_at": "2016-08-08 15:57:08",
     *               "comment_count": 0,
     *               "favorite_count": 0,
     *               "user": {
     *                   "id": 3,
     *                   "nickname": "宝宝",
     *                   "say": null,
     *                   "avatar": "uploads/user/avatar.jpg",
     *                   "mobile": null,
     *                   "email": null,
     *                   "sex": 0,
     *                   "status": 1,
     *                   "is_admin": 0,
     *                   "qq_binding": 0,
     *                   "weixin_binding": 0,
     *                   "weibo_binding": 0,
     *                   "email_binding": 0,
     *                   "mobile_binding": 0,
     *                   "created_at": "2016-08-08 15:24:53",
     *                   "updated_at": "2016-08-08 15:24:53"
     *                   }
     *               },
     *               {
     *               "id": 3,
     *               "user_id": 2,
     *               "content": "你们吃什么样的屎",
     *               "photo": null,
     *               "view": 12,
     *               "created_at": "2016-08-08 15:55:08",
     *               "updated_at": "2016-08-08 15:55:08",
     *               "comment_count": 0,
     *               "favorite_count": 0,
     *               "user": {
     *                   "id": 2,
     *                   "nickname": "宝宝",
     *                   "say": null,
     *                   "avatar": "uploads/user/avatar.jpg",
     *                   "mobile": null,
     *                   "email": null,
     *                   "sex": 0,
     *                   "status": 1,
     *                   "is_admin": 0,
     *                   "qq_binding": 0,
     *                   "weixin_binding": 0,
     *                   "weibo_binding": 0,
     *                   "email_binding": 0,
     *                   "mobile_binding": 0,
     *                   "created_at": "2016-08-08 15:24:26",
     *                   "updated_at": "2016-08-08 15:24:26"
     *               }
     *               }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询动弹列表失败"
     *      }
     */
    public function getTrendsList(Request $request)
    {
        $trands = null;
        if ($request->type === 'new') {
            $trands = Trends::orderBy('id', 'desc')
                ->paginate(isset($request->count) ? $request->count : 10);
        } elseif ($request->type === 'hot') {
            $trands = Trends::orderBy('id', 'desc')
                ->orderBy('view', 'desc')
                ->paginate(isset($request->count) ? $request->count : 10);
        } elseif ($request->type === 'me') {
            $trands = Trends::orderBy('id', 'desc')
                ->where('user_id', isset($request->user_id) ? $request->user_id : 0)
                ->paginate(isset($request->count) ? $request->count : 10);
        }

        // 向单条数据里添加数据
        $data = $trands->all();
        if (count($data) == 0) {
            return $this->respondWithErrors('没有查询到动弹列表数据');
        }

        foreach ($data as $key => $value) {
            $data[$key]['comment_count'] = Comment::where('type', 'trends')->where('source_id', $value->id)->count();
            $data[$key]['favorite_count'] = Comment::where('type', 'trends')->where('source_id', $value->id)->count();
            $data[$key]['user'] = User::find($value->user_id);
        }

        return $this->respondWithSuccess([
            'total' => $trands->total(),
            'rows' => $trands->perPage(),
            'current_page' => $trands->currentPage(),
            'data' => $data,
        ], '查询动弹列表成功');
    }

    /**
     * @api {get} /getTrendsDetail.api 动弹详情
     * @apiDescription 获取动弹列表,可根据参数返回不同的数据
     * @apiGroup Trends
     * @apiPermission none
     * @apiParam {String} type 返回类型 new最新 hot热门 me我的
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiParam {Number} [user_id] 如果type是me,这个字段一定传
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     * 
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询动弹列表失败"
     *      }
     */
    public function getTrendsDetail(Request $request)
    {
        
    }

    // 发布动弹
    public function postTrends(Request $request)
    {
        
    }


}
