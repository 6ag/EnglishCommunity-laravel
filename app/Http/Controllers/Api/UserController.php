<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth');
    }

    /**
     * @api {post} /uploadUserAvatar.api 上传用户头像
     * @apiDescription 上传用户头像
     * @apiGroup User
     * @apiPermission none
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiParam {String} photo base64编码的图片
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "上传头像成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "上传头像失败"
     *      }
     */
    public function uploadUserAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'photo' => ['required']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'photo.required' => 'photo不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 获取图片
        $image = Image::make($request->photo)->resize(150, 150);
        $fileName = md5(uniqid(microtime(true), true)) . '.jpg';

        // 根据日期创建目录 uploads/user/avatar/
        $directory = 'uploads/user/avatar/';
        if (!file_exists($directory)) {
            if (!(mkdir($directory, 0777, true) && chmod($directory, 0777))) {
                return $this->respondWithErrors('无权限创建路径,请设置public下的uploads目录权限为777', 500);
            }
        }

        // 保存图片
        $avatarPath = $directory . $fileName;
        $image->save($avatarPath);

        // 修改保存的图片权限
        @chmod($avatarPath, 0777);

        // 更新记录
        $user = User::find($request->user_id);
        if ($user->avatar != 'uploads/user/default/avatar.jpg') {
            @unlink($user->avatar);
        }
        $user->avatar = $avatarPath;
        $user->save();

        return $this->respondWithSuccess(null, '上传头像成功');
    }

    /**
     * @api {get} /getUserInfomation.api 获取用户信息
     * @apiDescription 获取用户信息
     * @apiGroup User
     * @apiPermission none
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "获取用户信息成功",
     *           "result": {
     *               "token": "xxxx.xxxxxxx.xxxxxxxx",
     *               "id": 10000,
     *               "nickname": "管理员",
     *               "say": "Hello world!",
     *               "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg",
     *               "mobile": "15626427299",
     *               "email": "admin@6ag.cn",
     *               "sex": 1,
     *               "qqBinding": 0,
     *               "weixinBinding": 0,
     *               "weiboBinding": 0,
     *               "emailBinding": 1,
     *               "mobileBinding": 1,
     *               "registerTime": "1471437181",
     *               "lastLoginTime": "1471715751"
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "获取用户信息失败"
     *      }
     */
    public function getUserInfomation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询用户表
        $user = User::find($request->user_id);
        if ($user->status == 0) {
            return $this->respondWithErrors('用户已被禁用', 403);
        }

        // 修改登录时间
        $user->update(['last_login_time' => Carbon::now()]);

        return $this->respondWithSuccess([
            'token' => JWTAuth::fromUser($user),
            'id' => $user->id,
            'nickname' => $user->nickname,
            'say' => $user->say,
            'avatar' => url($user->avatar),
            'mobile' => $user->mobile,
            'email' => $user->email,
            'sex' => $user->sex,
            'qqBinding' => $user->qq_binding,
            'weixinBinding' => $user->weixin_binding,
            'weiboBinding' => $user->weibo_binding,
            'emailBinding' => $user->email_binding,
            'mobileBinding' => $user->mobile_binding,
            'registerTime' => (string)$user->created_at->timestamp,
            'lastLoginTime' => (string)$user->last_login_time->timestamp,
        ], '获取用户信息成功');
    }

    /**
     * @api {post} /updateUserInfomation.api 更新用户信息
     * @apiDescription 更新用户信息
     * @apiGroup User
     * @apiPermission none
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id 用户id
     * @apiParam {String} [nickname] 昵称
     * @apiParam {Number} [sex] 0女 1男
     * @apiParam {String} [say] 个性签名
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "更新用户信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "更新用户信息失败"
     *      }
     */
    public function updateUserInfomation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'sex' => ['in:0,1']
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'sex.in' => 'sex 0女 1男'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        User::where('id', $request->user_id)->update($request->only(['nickname', 'sex', 'say']));
        return $this->respondWithSuccess(null, '更新用户信息成功');

    }
}
