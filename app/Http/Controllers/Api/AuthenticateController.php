<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Group;
use App\Http\Model\Permission;
use App\Http\Model\User;
use App\Http\Model\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends BaseController
{
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
     *           "code": 404,
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
     * @apiParam {String} identifier  账号
     * @apiParam {String} credential  密码
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
     *           "code": 404,
     *           "message": "用户名已经存在"
     *      }
     */
    public function register(Request $request)
    {
        // 验证表单
        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'between:5,16', 'unique:user_auths'],
            'credential' => ['required', 'min:6'],
//            'mobile' => ['required', 'unique:users'],
//            'code' => ['required'],
        ], [
            'identifier.required' => '用户名为必填项',
            'identifier.unique' => '用户名已经存在',
            'identifier.between' => '用户名长度必须是6-16',
            'credential.required' => '密码为必填项',
            'credential.min' => '密码长度最少6位',
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

        // 创建用户
        $user = new User();
        $user->save();

        // 创建授权
        $userAuth = new UserAuth();
        $userAuth->user_id = $user->id;
        $userAuth->identity_type = 'username';
        $userAuth->identifier = $request->identifier;
        $userAuth->credential = bcrypt($request->credential);
        $userAuth->save();

        return $this->respondWithSuccess(null, '注册成功');
    }

    /**
     * @api {post} /auth/login.api app登录
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} identifier  账号
     * @apiParam {String} credential  密码
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
     *               "sex": 0,
     *               "qq_binding": 0,
     *               "weixin_binding": 0,
     *               "weibo_binding": 0,
     *               "phone_binding": 0,
     *               "email_binding": 0,
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

        // 3种登录方式,查询其中一条记录即可
        $userAuth = UserAuth::where('identifier' , $request->identifier)
            ->whereIn('identity_type', ['username', 'mobile', 'email'])
            ->first();
        if (isset($userAuth) && Hash::check($request->credential, $userAuth->credential)) {
            // 更新凭证
//            if (Hash::needsRehash($userAuth->credential)) {
//                $userAuth->credential = bcrypt($request->credential);
//                $userAuth->save();
//            }

            // 查询用户表
            $user = User::find($userAuth->user_id);
            if ($user->status == 0) {
                return $this->respondWithErrors('登录失败,用户已被禁用');
            }

            return $this->respondWithSuccess([
                'token' => JWTAuth::fromUser($user),
                'id' => $user->id,
                'nickname' => $user->nickname,
                'say' => $user->say,
                'avatar' => $user->avatar,
                'mobile' => $user->mobile,
                'sex' => $user->sex,
                'qq_binding' => $user->qq_binding,
                'weixin_binding' => $user->weixin_binding,
                'weibo_binding' => $user->weibo_binding,
                'email_binding' => $user->email_binding,
                'mobile_binding' => $user->phone_binding,
            ], '登录成功');
        } else {
            return $this->respondWithErrors('登录失败,密码错误');
        }

    }

    /**
     * 刷新token
     * @return \Illuminate\Http\Response
     */
    public function refreshToken()
    {
        $token = JWTAuth::refresh();
        return $this->respondWithSuccess([
            'token' => $token,
        ], '刷新token成功');
    }

    /**
     * @api {post} /auth/modifyUserPassword.api 修改用户密码
     * @apiGroup Auth
     * @apiPermission none
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
            'user_id' => ['required', 'exists:users'],
            'credential_old' => ['required'],
            'credential_new' => ['required', 'between:6,20'],
        ], [
            'user_id.required' => '用户id必须传',
            'user_id.exists' => '用户不存在',
            'credential_old.required' => '旧密码必须传',
            'credential_new.required' => '新密码不能为空!',
            'credential_new.between' => '新密码必须在6-20位之间',
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

            return $this->respondWithSuccess(null, '修改密码成功');
        }

        return $this->respondWithErrors('旧密码错误');
    }

}
