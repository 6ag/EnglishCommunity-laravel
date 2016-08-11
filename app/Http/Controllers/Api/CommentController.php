<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Comment;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CommentController extends BaseController
{
    /**
     * @api {get} /postComment.api 发布评论
     * @apiDescription 发布或者回复一条评论
     * @apiGroup Comment
     * @apiPermission none
     * @apiParam {Number} user_id 用户id
     * @apiParam {String} type 类型:trends/video
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiParam {String} content 评论内容
     * @apiParam {Number} [pid] 默认0,评论当前主题.为其他评论id则是回复评论
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "发布评论信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "发布评论信息失败"
     *      }
     */
    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'type' => ['required'],
            'source_id' => ['required'],
            'content' => ['required'],
        ], [
            'user_id.required' => 'user_id字段不能为空',
            'type.required' => 'type字段不能为空',
            'source_id.required' => 'source_id字段不能为空',
            'content.required' => 'content字段不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 验证回复的评论是否存在
        $pid = isset($request->pid) ? $request->pid : 0;
        if ($pid != 0) {
            $pComment = Comment::where('source_id', $request->source_id)->where('type', $request->type)->where('id', $pid)->first();
            if (! isset($pComment)) {
                return $this->respondWithErrors('没有找到当前source_id下pid对应的评论信息');
            }
        } else {
            // 通知被回复的用户

        }

        // 添加评论信息
        Comment::create($request->all());
        return $this->respondWithSuccess(null, '添加评论成功');

    }

    /**
     * @api {get} /getCommentList.api 获取评论列表
     * @apiDescription 获取动弹或视频信息的评论列表
     * @apiGroup Comment
     * @apiPermission none
     * @apiParam {String} type 类型:trends/video
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询评论列表成功",
     *           "data": {
     *               "total": 4,
     *               "rows": 2,
     *               "current_page": 1,
     *               "data": [
     *                   {
     *                       "id": 1,
     *                       "type": "trends",
     *                       "source_id": 43,
     *                       "user_id": 2,
     *                       "content": "一起吃行不",
     *                       "pid": 0,
     *                       "created_at": "2016-08-10 14:40:12",
     *                       "updated_at": "2016-08-10 14:40:12",
     *                       "user_nickname": "王麻子",
     *                       "user_avatar": "uploads/user/avatar.jpg"
     *                   },
     *                   {
     *                       "id": 2,
     *                       "type": "trends",
     *                       "source_id": 43,
     *                       "user_id": 1,
     *                       "content": "完全可以啊",
     *                       "pid": 1,
     *                       "created_at": "2016-08-10 14:40:12",
     *                       "updated_at": "2016-08-10 14:40:12",
     *                       "user_nickname": "管理员",
     *                       "user_avatar": "uploads/user/avatar.jpg",
     *                       "puser_id": 2,
     *                       "puser_nickname": "王麻子",
     *                       "puser_avatar": "uploads/user/avatar.jpg"
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "没有任何评论信息"
     *      }
     */
    public function getCommentList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            'source_id' => ['required'],
        ], [
            'type.required' => 'type字段不能为空',
            'source_id.required' => 'source_id字段不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 单页数量
        $count = isset($request->count) ? (int)$request->count : 10;

        $comments = Comment::where(['source_id' => $request->source_id, 'type' => $request->type])->paginate($count);
        
        // 没有查询到数据
        $data = $comments->all();
        if (count($data) == 0) {
            return $this->respondWithErrors('没有任何评论信息', 404);
        }

        foreach ($data as $key => $value) {
            // 评论作者的信息
            $user = User::find($value->user_id);
            $data[$key]['user_nickname'] = $user->nickname;
            $data[$key]['user_avatar'] =  $user->avatar;

            // 如果是回复评论,则带上被回复用户的信息
            if ($value->pid != 0) {
                $comment = Comment::find($value->pid);
                $puser = User::find($comment->user_id);
                $data[$key]['puser_id'] = $puser->id;
                $data[$key]['puser_nickname'] = $puser->nickname;
                $data[$key]['puser_avatar'] =  $puser->avatar;
            }
        }

        return $this->respondWithSuccess([
            'total' => $comments->total(),
            'rows' => $comments->perPage(),
            'current_page' => $comments->currentPage(),
            'data' => $comments->all(),
        ], '查询评论列表成功');
    }
}


