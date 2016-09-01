<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Friend;
use App\Http\Model\Group;
use App\Http\Model\Permission;
use App\Http\Model\User;
use App\Http\Model\UserAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'sendCkeckCode',
                'register',
                'login',
                'retrievePasswordWithSendEmail'
            ]
        ]);
    }

    // 短信接口地址
    protected $smsApiUrl = 'http://sms-api.luosimao.com/v1/send.json';
    // 短信密钥
    protected $smsApiKey = '';

    /**
     * 发送短信验证码
     * @param $mobile 手机号码
     * @param $message 发送的消息内容
     * @return bool
     */
    protected function sendCheckSms($mobile, $message) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->smsApiUrl);                  // 发送的目标URL
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);                     // 连接超时时间
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                   // 返回数据并且不直接打印
        curl_setopt($ch, CURLOPT_HEADER, false);                          // 不设置头信息
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);               // 基础授权验证
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $this->smsApiKey); // 前面是用户名  后面是密码
        curl_setopt($ch, CURLOPT_PORT, true);

        // post请求体
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'mobile' => $mobile,
            'message' => $message . '【自学英语】',
        ]);

        // 发送post请求并接收返回结果
        $result = curl_exec($ch);

        // 关闭句柄
        curl_close($ch);

        $result = json_decode($result, true);

        if ($result['error'] == 0 && $result['msg'] == 'ok') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 生成随机数
     * @param int $len 随机数长度
     * @param string $format 格式
     * @return string
     */
    private function makeRandString($len = 6, $format = 'ALL')
    {
        switch ($format) {
            case 'ALL':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
            case 'CHAR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~';
                break;
            case 'NUMBER':
                $chars = '0123456789';
                break;
            default :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
        }
        mt_srand((double)microtime() * 1000000 * getmypid());
        $password = "";
        while (strlen($password) < $len) {
            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }

        return $password;
    }

    /**
     * @api {post} /auth/seedCode.api 发送验证码
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} mobile  手机号码
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "验证码发送成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "验证码发送失败"
     *      }
     */
    public function sendCkeckCode(Request $request)
    {
        $mobile = $request->mobile;
        if (! isset($mobile)) {
            return $this->respondWithErrors('手机号码为空');
        }

        // 获取验证码
        $randNum = $this->makeRandString(6, 'NUMBER');

        // 缓存5分钟
        $expiresAt = 5;
        Cache::put($mobile, $randNum, $expiresAt);

        // 短信内容
        $smsText = '验证码为:' . $randNum . ',请在5分钟内使用!';

        // 发送验证码短信
        $result = $this->sendCheckSms($mobile, $smsText);

        if (isset($result)) {
            return $this->respondWithSuccess(null, '验证码发送成功');
        } else {
            return $this->respondWithErrors('验证码发送失败');
        }

    }

    /**
     * @api {post} /auth/register.api app注册
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} type 注册类型(username)
     * @apiParam {String} identifier 唯一标识
     * @apiParam {String} credential 凭证
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "注册成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "用户名已经存在"
     *      }
     */
    public function register(Request $request)
    {
        // 验证表单
        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'between:5,16', 'unique:user_auths'],
            'credential' => ['required', 'min:6'],
            'type' => ['required'],
//            'mobile' => ['required', 'unique:users'],
//            'code' => ['required'],
        ], [
            'identifier.required' => '用户名为必填项',
            'identifier.unique' => '用户名已经存在',
            'identifier.between' => '用户名长度必须是6-16',
            'credential.required' => '密码为必填项',
            'credential.min' => '密码长度最少6位',
            'type.required' => '登录类型不能为空',
//            'mobile.required' => '手机号码必须填',
//            'mobile.users' => '手机号码已经存在',
//            'code.required' => '验证码必填',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 验证手机验证码
//        if (Cache::has($request->mobile)) {
//            $key = Cache::get($request->mobile);
//            if ($key != $request->code) {
//                return $this->respondWithErrors('验证码错误');
//            }
//        } else {
//            return $this->respondWithErrors('验证码错误');
//        }

        $collectionAll = collect(['username']);
        if (! $collectionAll->contains($request->type)) {
            return $this->respondWithErrors('不支持的注册方式', 400);
        }

        // 创建用户
        $user = new User();
        $user->save();

        // 创建授权
        $userAuth = new UserAuth();
        $userAuth->user_id = $user->id;
        $userAuth->identity_type = $request->type;
        $userAuth->identifier = $request->identifier;
        $userAuth->credential = bcrypt($request->credential);
        $userAuth->save();

        return $this->respondWithSuccess(null, '注册成功');
    }

    /**
     * @api {post} /auth/login.api app登录
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} type 登录类型(username email mobile qq weixin weibo)
     * @apiParam {String} identifier  唯一标识
     * @apiParam {String} credential  凭证
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "登录成功",
     *           "result": {
     *               "token": "xxxx.xxxxxxx.xxxxxxxx",
     *               "id": 4,
     *               "nickname": "佚名",
     *               "say": null,
     *               "avatar": "http://www.english.com/uploads/user/avatar.jpg",
     *               "mobile": null,
     *               "email": null,
     *               "sex": 0,
     *               "qqBinding": 0,
     *               "weixinBinding": 0,
     *               "weiboBinding": 0,
     *               "emailBinding": 0,
     *               "mobileBinding": 0,
     *               "followersCount": 32,
     *               "followingCount": 2,
     *               "registerTime": "1471685857",
     *               "lastLoginTime": "1471685891"
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
            'type' => ['required', 'in:username,email,mobile,qq,weixin,weibo'],
        ], [
            'type.required' => '登录类型不能为空',
            'type.in' => '登录类型必须为username,email,mobile,qq,weixin,weibo其中一种'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 根据登录类型,进行不同的查询
        $collectionAll = collect(['username', 'email', 'mobile', 'qq', 'weixin', 'weibo']);
        $collectionWeb = collect(['username', 'email', 'mobile']);
        $collectionVendor = collect(['qq', 'weixin', 'weibo']);

        // 不支持的登录方式
        if (! $collectionAll->contains($request->type)) {
            return $this->respondWithErrors('不支持的登录方式', 400);
        }

        // 查询到的用户id
        $user_id = 0;

        if ($collectionWeb->contains($request->type)) { // 站内
            // 验证输入
            $validator = Validator::make($request->all(), [
                'identifier' => ['required', 'exists:user_auths'],
                'credential' => ['required'],
            ], [
                'identifier.exists' => '用户不存在',
                'identifier.required' => '用户名、手机号码或邮箱为必填项',
                'credential.required' => '密码为必填项',
            ]);
            if ($validator->fails()) {
                return $this->respondWithFailedValidation($validator);
            }
            $userAuth = UserAuth::where('identifier', $request->identifier)->whereIn('identity_type', ['username', 'mobile', 'email'])->first();
            if (isset($userAuth) && Hash::check($request->credential, $userAuth->credential)) {
                $user_id = $userAuth->user_id;
            }

        } elseif ($collectionVendor->contains($request->type)) { // 第三方

            // 验证输入
            $validator = Validator::make($request->all(), [
                'identifier' => ['required'],
                'token' => ['required'],
                'nickname' => ['required'],
                'avatar' => ['required'],
                'sex' => ['required'],
            ], [
                'identifier.required' => 'identifier为必填项',
                'token.required' => 'token为必填项',
                'nickname.required' => 'nickname为必填项',
                'avatar.required' => '密码为必填项',
                'sex.required' => '密码为必填项',
            ]);
            if ($validator->fails()) {
                return $this->respondWithFailedValidation($validator);
            }

            $userAuth = UserAuth::where('identifier', $request->identifier)->whereIn('identity_type', ['qq', 'weibo', 'weixin'])->first();
            if (isset($userAuth)) {
                $user_id = $userAuth->user_id;
            } else {
                // 新建用户和第三方授权记录
                $newUser = User::create([
                    'nickname' => $request->nickname,
                    'avatar' => $request->avatar,
                    'sex' => $request->sex,
                ]);
                // 修改用户绑定记录
                if ($request->type == 'qq') {
                    $newUser->update(['qq_binding' => 1]);
                } elseif ($request->type == 'weibo') {
                    $newUser->update(['weibo_binding' => 1]);
                } elseif ($request->type == 'weixin') {
                    $newUser->update(['weixin_binding' => 1]);
                }
                // 创建第三方授权信息
                UserAuth::create([
                    'user_id' => $newUser->id,
                    'identity_type' => $request->type,
                    'identifier' => $request->identifier,
                    'credential' => $request->token,
                    'verified' => 1
                ]);
                $user_id = $newUser->id;
            }
        }

        if ($user_id != 0) {
            // 查询用户表
            $user = User::find($user_id);
            if ($user->status == 0) {
                return $this->respondWithErrors('登录失败, 用户已被禁用', 403);
            }

            // 修改登录时间
            $user->update(['last_login_time' => Carbon::now()]);

            return $this->respondWithSuccess([
                'token' => JWTAuth::fromUser($user),
                'expiryTime' => (string)(Carbon::now()->timestamp + config('jwt.ttl') * 60),
                'id' => $user->id,
                'nickname' => $user->nickname,
                'say' => $user->say,
                'avatar' => substr($user->avatar, 0, 4) == 'http' ? $user->avatar : url($user->avatar),
                'mobile' => $user->mobile,
                'email' => $user->email,
                'sex' => $user->sex,
                'adDsabled' => $user->ad_disabled,
                'qqBinding' => $user->qq_binding,
                'weixinBinding' => $user->weixin_binding,
                'weiboBinding' => $user->weibo_binding,
                'emailBinding' => $user->email_binding,
                'mobileBinding' => $user->mobile_binding,
                'followersCount' => Friend::where('user_id', $user_id)->where('relation', 0)->count(),
                'followingCount' => Friend::where('user_id', $user_id)->where('relation', 1)->count(),
                'registerTime' => (string)$user->created_at->timestamp,
                'lastLoginTime' => (string)$user->last_login_time->timestamp,
            ], '登录成功');
        } else {
            return $this->respondWithErrors('登录失败, 密码错误', 403);
        }

    }

    /**
     * @api {post} /auth/modifyUserPassword.api 修改用户密码
     * @apiGroup Auth
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {Number} user_id  用户id
     * @apiParam {String} credential_old  密码
     * @apiParam {String} credential_new  新密码
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "修改密码成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "旧密码错误"
     *      }
     */
    public function modifyUserPassword(Request $request)
    {
        // 验证输入字段
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'credential_old' => ['required'],
            'credential_new' => ['required', 'between:6,20'],
        ], [
            'user_id.required' => 'user_id不能为空',
            'user_id.exists' => '用户不存在',
            'credential_old.required' => 'credential_old不能为空',
            'credential_new.required' => 'credential_new不能为空!',
            'credential_new.between' => 'credential_new必须在6-20位之间',
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询用户权限表,修改密码
        $userAuths = UserAuth::where('user_id', $request->user_id)
            ->whereIn('identity_type', ['username', 'email', 'mobile'])
            ->get();

        if (count($userAuths) && Hash::check($request->credential_old, $userAuths[0]->credential)) {
            UserAuth::where('user_id', $request->user_id)
                ->whereIn('identity_type', ['username', 'email', 'mobile'])
                ->update(['credential' => bcrypt($request->credential_new)]);

            // 查询是否已经绑定了邮箱
            $emailAuth = UserAuth::where('user_id', $request->user_id)->where('identity_type', 'email')->first();
            if (isset($emailAuth)) {

                // 获取邮箱
                $email = $emailAuth->identifier;

                // 查询邮箱是否已经验证
                $emailUser = User::find($emailAuth->user_id);
                if (isset($emailUser) && $emailUser->email_binding == 1) {

                    // 发送邮件通知
                    Mail::raw('您的密码已经修改成功, 新密码为【 ' . $request->credential_new . ' 】。', function ($message) use ($email) {
                        $message ->to($email)->subject('密码修改成功');
                    });
                }
            }

            return $this->respondWithSuccess(null, '修改密码成功');
        }

        return $this->respondWithErrors('旧密码错误', 403);
    }

    /**
     * @api {post} /auth/retrievePasswordWithSendEmail.api 重置密码邮件
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} identifier username账号
     * @apiParam {String} email 绑定的邮箱
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *     {
     *           "status": "success",
     *           "code": 200,
     *           "message": "邮件发送成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "邮件发送失败"
     *      }
     */
    public function retrievePasswordWithSendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'exists:user_auths'],
            'email' => ['required', 'exists:user_auths,identifier']
        ], [
            'identifier.required' => '用户名不能为空',
            'identifier.exists' => '用户不存在',
            'email.required' => '邮箱不能为空',
            'email.exists' => '邮箱不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $userAuth = UserAuth::where('identifier', $request->identifier)->where('identity_type', 'username')->first();
        $emailAuth = UserAuth::where('identifier', $request->email)->where('identity_type', 'email')->first();

        // 验证用户名和邮箱是否属于同一个用户的授权
        if ($userAuth->user_id != $emailAuth->user_id) {
            return $this->respondWithErrors('用户名和邮箱不匹配');
        }

        // 随机生成新密码
        $newPassword = $this->makeRandString(6);
        $email = $request->email;

        $user = User::find($emailAuth->user_id);
        // 查询邮箱是否已经验证
        if (isset($user) && $user->email_binding == 1) {
            // 发送邮件通知
            Mail::raw('您的密码已经重置成功, 新密码为【 ' . $newPassword . ' 】, 请尽快修改密码(中括号内6位字符为新的密码)。', function ($message) use ($email) {
                $message ->to($email)->subject('找回密码');
            });

            // 需要修改的用户
            UserAuth::where('user_id', $userAuth->user_id)
                ->whereIn('identity_type', ['username', 'email', 'mobile'])
                ->update(['credential' => bcrypt($newPassword)]);

            return $this->respondWithSuccess(null, '发送成功,请查看邮箱');
        } else {
            return $this->respondWithErrors('您的邮箱未通过验证,请联系管理员');
        }

    }

}
