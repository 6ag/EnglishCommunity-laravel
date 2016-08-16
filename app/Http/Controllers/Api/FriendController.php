<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Friend;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class FriendController extends BaseController
{
    /**
     * @api {get} /getFriendList.api 朋友关系列表
     * @apiDescription 获取朋友关系列表(关注、粉丝)
     * @apiGroup Friend
     * @apiPermission none
     * @apiParam {Number} user_id 当前用户的id
     * @apiParam {String} relation 关系类型 0粉丝 1关注
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询动弹列表失败"
     *      }
     */
    public function getFriendList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'relation' => ['required', 'in:0,1']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'relation.required' => 'relation不能为空',
            'relation.in' => '0:粉丝 1:关注 不能传其他值'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $friends = Friend::where('user_id', $request->user_id)->where('relation', $request->relation)->get();
        if (count($friends) == 0) {
            return $this->respondWithErrors('没有查询到朋友关系数据');
        }

        $result = null;
        foreach ($friends as $key => $value) {
            $user = User::find($value->relation_user_id);
            $result[$key]['relationUserId'] = $user->id;
            $result[$key]['relationNickname'] = $user->nickname;
            $result[$key]['relationAvatar'] = url($user->avatar);
        }

        return $this->respondWithSuccess($result, '查询朋友关系列表成功');

    }

    // 关注某人 user_id
    public function attention(Request $request)
    {
        
    }

    // 取消关注某人 user_id
    public function unAttention(Request $request)
    {
        
    }
}
