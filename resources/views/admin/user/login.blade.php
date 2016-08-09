@extends('layouts.login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <b>后台管理系统</b>
        </div>

        <div class="login-box-body">

            @include('layouts.Common.tips')

            <form action="#" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="用户名" name="identifier" value="{{ old('identifier') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="密码" name="credential" value="{{ old('credential') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <a href="{{ route('admin.register') }}" class="btn btn-info btn-block btn-flat">注册</a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection