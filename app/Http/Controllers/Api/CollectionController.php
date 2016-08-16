<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Collection;
use App\Http\Model\User;
use App\Http\Model\VideoInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CollectionController extends BaseController
{
    /**
     * @api {post} /collectVideoInfo.api 收藏视频
     * @apiDescription 收藏视频信息
     * @apiGroup Collection
     * @apiPermission none
     * @apiParam {Number} user_id 用户id
     * @apiParam {Number} video_info_id 视频信息的id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "收藏视频信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "收藏视频信息失败"
     *      }
     */
    public function collectVideoInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'video_info_id' => ['required', 'exists:video_infos,id'],
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'video_info_id.required' => 'video_info_id不能为空',
            'video_info_id.exists' => '视频信息不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        Collection::create($request->only(['user_id', 'video_info_id']));
        return $this->respondWithSuccess(null, '收藏视频信息成功');
    }

    /**
     * @api {get} /getCollectionList.api 获取收藏列表
     * @apiDescription 获取指定用户的收藏列表
     * @apiGroup Collection
     * @apiPermission none
     * @apiParam {Number} user_id 用户id
     * @apiParam {Number} [page] 页码,默认当然是第1页
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "收藏视频信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "收藏视频信息失败"
     *      }
     */
    public function getCollectionList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $count = isset($request->count) ? (int)$request->count : 10;
        $collections = Collection::where('user_id', $request->user_id)
            ->paginate($count);

        // 没有数据
        if (! count($collections)) {
            return $this->respondWithErrors('没有任何收藏数据');
        }

        $result = null;
        // 查询视频信息
        foreach ($collections as $key => $collection) {
            $videoInfo = VideoInfo::find($collection->video_info_id);
            $result[$key]['id'] = $videoInfo->id;
            $result[$key]['title'] = $videoInfo->title;
            $result[$key]['cover'] = url($videoInfo->photo);
            $result[$key]['view'] = $videoInfo->view;
            $result[$key]['teacherName'] = $videoInfo->teacher;
            $result[$key]['videoType'] = $videoInfo->type;
            $result[$key]['recommended'] = $videoInfo->recommend;
        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $collections->total(),
                'currentPage' => $collections->currentPage(),
            ],
            'data' => $result,
        ], '查询动弹列表成功');
    }
}
