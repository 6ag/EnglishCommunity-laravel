<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Group;
use App\Http\Model\Permission;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends BaseController
{
    /**
     * @api {post} /auth/register app注册
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} username  账号
     * @apiParam {String} password  密码
     * @apiParam {String} password_confirmation 重复密码
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "注册成功",
     *           "data": {
     *               "username": "admin888"
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "用户名已经存在"
     *      }
     */
    public function register(Request $request)
    {
        // 验证表单
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'between:5,16', 'unique:users'],
            'password' => ['required', 'between:6,16', 'confirmed'],
        ], [
            'username.required' => '用户名为必填项',
            'username.unique' => '用户名已经存在',
            'username.between' => '用户名长度必须是6-16',
            'password.required' => '密码为必填项',
            'password.between' => '密码长度必须是6-16',
            'password.confirmed' => '两次输入的密码不一致',
        ]);

        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 创建用户
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->respondWithSuccess([
            'username' => $user->username,
        ], '注册成功');
    }

    /**
     * @api {post} /auth/login app登录
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} username  账号
     * @apiParam {String} password  密码
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "登录成功",
     *           "data": {
     *               "token": "xxxx.xxxx.xxx-xx",
     *               "id": 1,
     *               "username": "admin",
     *               "nickname": "管理员",
     *               "say": null,
     *               "avatar": null,
     *               "mobile": null,
     *               "score": 0,
     *               "sex": 0,
     *               "qq_binding": 0,
     *               "wx_binding": 0,
     *               "wb_binding": 0,
     *               "group": "一级会员",
     *               "permission": "管理员",
     *               "status": 1,
     *               "register_time": -62169984000
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "用户不存在"
     *      }
     */
    public function login(Request $request)
    {
        // 验证输入
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'exists:users'],
            'password' => ['required'],
        ], [
            'username.exists' => '用户不存在',
            'username.required' => '用户名为必填项',
            'password.required' => '密码为必填项',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询用户信息
        $user = User::where('username', $request->username)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // 登录成功
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            return $this->respondWithSuccess([
                'token' => JWTAuth::fromUser($user),
                'id' => $user->id,
                'username' => $user->username,
                'nickname' => $user->nickname,
                'say' => $user->say,
                'avatar' => $user->avatar,
                'mobile' => $user->mobile,
                'score' => $user->score,
                'sex' => $user->sex,
                'qq_binding' => $user->qq_binding,
                'wx_binding' => $user->wx_binding,
                'wb_binding' => $user->wb_binding,
                'group' => Group::findOrFail($user->group_id)->name,
                'permission' => Permission::findOrFail($user->permission_id)->name,
                'status' => $user->status,
                'register_time' => $user->created_at->timestamp,
            ], '登录成功');
        } else {
            return $this->respondWithErrors('登录失败');
        }
    }

    public function updateToken()
    {
        $token = JWTAuth::refresh();
        return $this->respondWithSuccess([
            'token' => $token,
        ], '刷新token成功');
    }

    public function modify(Request $request)
    {

    }

}
