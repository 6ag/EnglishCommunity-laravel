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
                    @if(is_object($errors) && count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif

                    @if(is_string($errors))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{ $errors }}</p>
                        </div>
                    @endif
                </div>

                <div class="box-body">
                    <form role="form" action="{{ url('admin/modify') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="原密码" name="password_o">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="新密码" name="password">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="确认新密码" name="password_confirmation">
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


