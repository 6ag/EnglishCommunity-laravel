@extends('layouts.login')

@section('content')
    <div class="register-box">
        <div class="register-logo">
            <b>后台管理系统</b>
        </div>

        <div class="register-box-body">

            @include('layouts.Common.tips')

            <form action="#" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="用户名" name="identifier">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="密码" name="credential">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="确认密码" name="credential_confirmation">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" checked> 我同意这个《<a href="#">不平等协议</a>》
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection