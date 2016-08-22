<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\LikeRecord;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class LikeRecordController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth');
    }

    /**
     * @api {post} /addOrCancelLikeRecord.api 添加删除赞
     * @apiDescription 添加或删除赞
     * @apiGroup LikeRecord
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 当前用户id
     * @apiParam {String} type 赞类型 video_info或者tweet
     * @apiParam {Number} source_id 视频或者动弹的id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "赞成功",
     *           "result": {
     *               "type": "add"
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "赞操作失败"
     *      }
     */
    public function addOrCancelLikeRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'in:video_info,tweet'],
            'source_id' => ['required']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'type.required' => 'type不能为空',
            'type.in' => 'type只能为video_info、tweet',
            'source_id.required' => 'source_id不能为空'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $likeRecord = LikeRecord::where('user_id', $request->user_id)->where('type', $request->type)->where('source_id', $request->source_id)->first();
        if (isset($likeRecord)) {
            // 已经赞、则取消赞
            $likeRecord->delete();
            return $this->respondWithSuccess([
                'type' => 'cancel'
            ], '取消赞成功');
        } else {
            // 没有赞、则赞
            LikeRecord::create($request->only(['user_id', 'type', 'source_id']));
            return $this->respondWithSuccess([
                'type' => 'add'
            ], '赞成功');
        }

    }
}
