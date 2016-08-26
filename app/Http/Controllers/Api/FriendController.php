<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Friend;
use App\Http\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class FriendController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth');
    }

    /**
     * @api {get} /getFriendList.api 朋友关系列表
     * @apiDescription 获取朋友关系列表(关注、粉丝)
     * @apiGroup Friend
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 当前用户的id
     * @apiParam {String} relation 关系类型 0粉丝 1关注
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询朋友关系列表成功",
     *           "result": [
     *               {
     *                   "relationUserId": 10001,
     *                   "relationNickname": "王麻子",
     *                   "relationAvatar": "http://www.english.com/uploads/user/default/avatar.jpg"
     *               },
     *               {
     *                   "relationUserId": 10002,
     *                   "relationNickname": "李二狗",
     *                   "relationAvatar": "http://www.english.com/uploads/user/default/avatar.jpg"
     *               }
     *           ]
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "没有查询到朋友关系数据"
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

        if ($request->relation == 0) {
            // 查询粉丝
            $friends = Friend::where('relation_user_id', $request->user_id)->get();
        } else {
            // 查询关注
            $friends = Friend::where('user_id', $request->user_id)->get();
        }

        if (count($friends) == 0) {
            return $this->respondWithErrors('没有查询到朋友关系数据');
        }

        $result = null;
        foreach ($friends as $key => $value) {

            if ($request->relation == 0) {
                $user = User::find($value->user_id);
            } else {
                $user = User::find($value->relation_user_id);
            }

            $result[$key]['relationUserId'] = $user->id;
            $result[$key]['relationNickname'] = $user->nickname;
            $result[$key]['relationAvatar'] = substr($user->avatar, 0, 4) == 'http' ? $user->avatar : url($user->avatar);
            $result[$key]['relationSex'] = $user->sex;
            $result[$key]['relationSay'] = $user->say;
        }

        return $this->respondWithSuccess($result, '查询朋友关系列表成功');

    }

    /**
     * @api {get} /addOrCancelFriend.api 添加或删除关注
     * @apiDescription 添加或删除关注
     * @apiGroup Friend
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 当前用户的id
     * @apiParam {Number} relation_user_id 关注或移除关注的用户的id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "关注成功",
     *           "result": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "用户不存在"
     *      }
     */
    public function addOrCancelFriend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'relation_user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'uesr_id不能为空',
            'user_id.exists' => '当前用户不存在',
            'relation_user_id.required' => 'relation_user_id不能为空',
            'relation_user_id.exists' => '关注的用户不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询关注记录是否存在
        $friend = Friend::where('user_id', $request->user_id)->where('relation', 1)->where('relation_user_id', $request->relation_user_id)->first();
        if (isset($friend)) {
            $friend->delete();
            return $this->respondWithSuccess([
                'type' => 'cancel'
            ], '取消关注成功');
        } else {
            Friend::create([
                'user_id' => $request->user_id,
                'relation' => 1,
                'relation_user_id' => $request->relation_user_id
            ]);
            return $this->respondWithSuccess([
                'type' => 'add'
            ], '关注成功');
        }

    }

}
