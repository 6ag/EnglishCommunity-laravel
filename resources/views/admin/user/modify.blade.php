@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                修改密码
                <small>修改管理员密码</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">修改密码</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-warning">
                <div class="box-header with-border">
                    @include('layouts.Common.tips')
                </div>

                <div class="box-body">
                    <form role="form" action="{{ url('admin/modify') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="原密码" name="credential_o">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="新密码" name="credential">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="确认新密码" name="credential_confirmation">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">确认修改</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

    </div>
@endsection


