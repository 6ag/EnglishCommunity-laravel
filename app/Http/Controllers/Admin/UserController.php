<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
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
        if ($request->method() === 'POST') {
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
                return back()->withErrors($validator);
            }

            // 创建管理员
            $user = new User();
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->permission_id = 2;
            $user->save();

            return redirect()->route('admin.login')->with(['username' => $request->username, 'password' => $request->password]);
        }
        return view('admin.user.register');
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
                'username' => ['required', 'exists:users'],
                'password' => ['required', 'between:6,16'],
            ], [
                'username.exists' => '邮箱不存在',
                'username.required' => '邮箱为必填项',
                'password.required' => '密码为必填项',
                'password.between' => '密码长度必须是6-16',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            // 查询用户信息
            $user = User::where('username', $request->username)->where('permission_id', 2)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                // 登录成功
                if (Hash::needsRehash($user->password)) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                }
                
                Session::put('user', $user);
                return redirect()->route('admin.index');
            }
            return back()->with('errors', '管理员密码错误');
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
        if ($input = $request->all()) {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required' => '新密码不能为空!',
                'password.between' => '新密码必须在6-20位之间',
                'password.confirmed' => '新密码和确认密码不一致',
            ];

            $validator = Validator::make($input, $rules, $message);

            if ($validator->passes()) {
                $user = Session::get('user');
                if ($user && Hash::check($request->password_o, $user->password)) {
                    $user->password = bcrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '修改密码成功!');
                } else {
                    return back()->with('errors', '原密码错误!');
                }
            } else {
                return back()->withErrors($validator);
            }
        } else {
            return view('admin.user.modify');
        }
    }
    
}
