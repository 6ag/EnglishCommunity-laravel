<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Friend;
use App\Http\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getOtherUserInfomation'
            ]
        ]);
    }

    /**
     * @api {post} /uploadUserAvatar.api 上传用户头像
     * @apiDescription 上传用户头像
     * @apiGroup User
     * @apiPermission Token
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
     * @api {get} /getUserInfomation.api 自己用户信息
     * @apiDescription 获取自己的用户信息
     * @apiGroup User
     * @apiPermission Token
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
     *               "followersCount": 32,
     *               "followingCount": 2,
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
    public function getSelfUserInfomation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
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

        return $this->respondWithSuccess([
            'id' => $user->id,
            'nickname' => $user->nickname,
            'say' => $user->say,
            'avatar' => url($user->avatar),
            'mobile' => $user->mobile,
            'email' => $user->email,
            'sex' => $user->sex,
            'adDsabled' => $user->ad_disabled,
            'qqBinding' => $user->qq_binding,
            'weixinBinding' => $user->weixin_binding,
            'weiboBinding' => $user->weibo_binding,
            'emailBinding' => $user->email_binding,
            'mobileBinding' => $user->mobile_binding,
            'followersCount' => Friend::where('user_id', $request->user_id)->where('relation', 0)->count(),
            'followingCount' => Friend::where('user_id', $request->user_id)->where('relation', 1)->count(),
            'registerTime' => (string)$user->created_at->timestamp,
            'lastLoginTime' => (string)$user->updated_at->timestamp,
        ], '获取用户信息成功');

    }

    /**
     * @api {get} /getOtherUserInfomation.api 他人用户信息
     * @apiDescription 获取他人的用户信息
     * @apiGroup User
     * @apiPermission none
     * @apiParam {Number} user_id 当前登录的用户id
     * @apiParam {Number} other_user_id 需要用户信息的用户id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "获取用户信息成功",
     *           "result": {
     *               "id": 10000,
     *               "nickname": "管理员",
     *               "say": "Hello world!",
     *               "avatar": "http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg",
     *               "sex": 1,
     *               "followersCount": 32,
     *               "followingCount": 2,
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
    public function getOtherUserInfomation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_user_id' => ['required', 'exists:users,id'],
            'user_id' => ['required', 'exists:users,id']
        ], [
            'other_user_id.required' => 'other_user_id不能为空',
            'other_user_id.exists' => '用户不存在',
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询用户表
        $user = User::find($request->other_user_id);
        if ($user->status == 0) {
            return $this->respondWithErrors('用户已被禁用', 403);
        }

        // 查找当前用户是否已经关注了目标用户
        $friend = Friend::where('user_id', $request->user_id)->where('relation', 1)->where('relation_user_id', $request->other_user_id)->first();
        $followed = $request->user_id == $request->other_user_id ? 1 : (isset($friend) ? 1 : 0);

        return $this->respondWithSuccess([
            'id' => $user->id,
            'nickname' => $user->nickname,
            'say' => $user->say,
            'avatar' => url($user->avatar),
            'sex' => $user->sex,
            'followersCount' => Friend::where('user_id', $request->other_user_id)->where('relation', 0)->count(),
            'followingCount' => Friend::where('user_id', $request->other_user_id)->where('relation', 1)->count(),
            'followed' => $followed,
            'registerTime' => (string)$user->created_at->timestamp,
            'lastLoginTime' => (string)$user->updated_at->timestamp,
        ], '获取用户信息成功');

    }

    /**
     * @api {post} /updateUserInfomation.api 更新用户信息
     * @apiDescription 更新用户信息
     * @apiGroup User
     * @apiPermission Token
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

    /**
     * @api {post} /buyDislodgeDdvertisement.api 购买去除广告
     * @apiDescription  购买去除广告
     * @apiGroup User
     * @apiPermission Token
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
     *           "message": "购买去除广告成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "购买去除广告失败"
     *      }
     */
    public function buyDislodgeDdvertisement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ], [
            'user_id.required' => 'user_id不能为空',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $user = User::find($request->user_id);

        if (isset($user)) {
            $user->ad_disabled = 1;
            $user->save();
            return $this->respondWithSuccess(null, '禁用广告成功');
        } else {
            return $this->respondWithErrors('购买失败');
        }
    }
}
