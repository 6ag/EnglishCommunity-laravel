<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Model\UserAuth;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * 注册
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        // 已经登录则直接跳转
        if (Session::has('user')) {
            return redirect()->route('admin.index');
        }

        if ($request->method() === 'GET') {
            return view('admin.user.register');
        }

        // 验证表单
        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'between:6,16', 'unique:user_auths'],
            'credential' => ['required', 'between:6,16', 'confirmed'],
        ], [
            'identifier.required' => '用户名为必填项',
            'identifier.unique' => '用户名已经存在',
            'identifier.between' => '用户名长度必须是6-16',
            'credential.required' => '密码为必填项',
            'credential.between' => '密码长度必须是6-16',
            'credential.confirmed' => '两次输入的密码不一致',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 创建用户
        $user = new User();
        $user->is_admin = 1;
        $user->save();

        // 创建授权
        $userAuth = new UserAuth();
        $userAuth->user_id = $user->id;
        $userAuth->identity_type = 'username';
        $userAuth->identifier = $request->identifier;
        $userAuth->credential = bcrypt($request->credential);
        $userAuth->save();

        return redirect()->route('admin.login')->with(['identifier' => $request->identifier, 'credential' => $request->credential]);
    }

    /**
     * 登录
     * @param Request $request
     * @return $this
     */
    public function login(Request $request)
    {
        // 已经登录则直接跳转
        if (Session::has('user')) {
            return redirect()->route('admin.index');
        }

        if ($request->method() === 'POST') {
            // 验证输入
            $validator = Validator::make($request->all(), [
                'identifier' => ['required', 'exists:user_auths'],
                'credential' => ['required', 'between:6,16'],
            ], [
                'identifier.exists' => '用户不存在',
                'identifier.required' => '用户名为必填项',
                'credential.required' => '密码为必填项',
                'credential.between' => '密码长度必须是6-16',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            // 授权信息
            $userAuth = UserAuth::where('identifier' , $request->identifier)
                ->whereIn('identity_type', ['username', 'phone', 'email'])
                ->first();
            if (isset($userAuth) && Hash::check($request->credential, $userAuth->credential)) {
                // 更新凭证
                if (Hash::needsRehash($userAuth->credential)) {
                    $userAuth->credential = bcrypt($request->credential);
                    $userAuth->save();
                }

                // 查询用户表
                $user = User::find($userAuth->user_id);
                Session::put('user', $user);
                return redirect()->route('admin.index');
            } else {
                return back()->with('errors', '管理员密码错误');
            }
        }

        return view('admin.user.login');
    }

    /**
     * 退出登录
     * @return mixed
     */
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('admin.login');
    }

    /**
     * 修改密码
     * @param Request $request
     * @return $this
     */
    public function modify(Request $request)
    {
        if ($request->method() === 'GET') {
            return view('admin.user.modify');
        }

        // 验证输入字段
        $validator = Validator::make($request->all(), [
            'credential' => 'required|between:6,20|confirmed',
        ], [
            'credential.required' => '新密码不能为空!',
            'credential.between' => '新密码必须在6-20位之间',
            'credential.confirmed' => '新密码和确认密码不一致',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 判断当前Session里的用户是否还有效
        $user = Session::get('user');
        if (! isset($user)) {
            return redirect()->route('admin.login')->with('errors', '登录超时');
        }

        // 查询用户权限表,修改密码
        $userAuths = UserAuth::where('user_id', $user->id)
            ->whereIn('identity_type', ['username', 'email', 'phone'])
            ->get();

        if (count($userAuths) && Hash::check($request->credential_o, $userAuths[0]->credential)) {
            UserAuth::where('user_id', $user->id)
                ->whereIn('identity_type', ['username', 'email', 'phone'])
                ->update(['credential' => bcrypt($request->credential)]);

            return back()->with('errors', '修改密码成功!');
        }

        return back()->with('errors', '原密码错误!');
    }

}
