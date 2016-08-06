<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Group;
use App\Http\Model\Permission;
use App\Http\Model\User;
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
    
    // 发送短信验证码
    protected function sendCheckSms($mobile, $message) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->smsApiUrl);                  // 发送的目标URL
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);                     // 连接超时时间
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                   // 返回数据并且不直接打印
        curl_setopt($ch, CURLOPT_HEADER, false);                          // 不设置头信息
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);               // 基础授权验证
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $this->smsApiKey); // : 前面是用户名  后面是密码
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
            'password' => ['required', 'between:6,16'],
            'mobile' => ['required', 'unique:users'],
            'code' => ['required'],
        ], [
            'username.required' => '用户名为必填项',
            'username.unique' => '用户名已经存在',
            'username.between' => '用户名长度必须是6-16',
            'password.required' => '密码为必填项',
            'password.between' => '密码长度必须是6-16',
            'mobile.required' => '手机号码必须填',
            'mobile.regex' => '手机号码不合法',
            'mobile.users' => '手机号码已经存在',
            'code.required' => '验证码必填',
        ]);

        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 验证手机验证码
        if (Cache::has($request->mobile)) {
            $key = Cache::get($request->mobile);
            if ($key != $request->code) {
                return $this->respondWithErrors('验证码错误');
            }
        } else {
            return $this->respondWithErrors('验证码错误');
        }

        // 创建用户
        $user = new User();
        $user->username = $request->username;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->respondWithSuccess([
            'username' => $user->username,
        ], '注册成功');
    }

    /**
     * 获取手机验证码
     * @param Request $request
     * @return \Illuminate\Http\Response
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

        if ($result) {
            return $this->respondWithSuccess([
                'mobile' => $mobile,
            ], '验证码发送成功');
        } else {
            return $this->respondWithErrors('验证码发送失败');
        }

    }

    // 生成随机数
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
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.exists' => '用户不存在',
            'username.required' => '用户名或手机号码为必填项',
            'password.required' => '密码为必填项',
        ]);

        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // 查询用户信息
        $user = User::where('username', $request->username)->first();
        if (! isset($user)) {
            $user = User::where('mobile', $request->username)->first();
        }

        // 验证密码是否正确
        if (isset($user) && Hash::check($request->password, $user->password)) {
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
     * 修改密码
     * @param Request $request
     */
    public function modifyPassword(Request $request)
    {

    }

}
