@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                基本信息
                <small>API系统基本信息</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">基本信息</li>
            </ol>
        </section>

        <section class="content">

            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i> 公告</h4>
                这里可以来一条公共吗?我觉得可以吧!
            </div>

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">系统信息</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-condensed">
                        <tbody>
                        <tr>
                            <td>操作系统</td>
                            <td>{{PHP_OS}}</td>
                        </tr>
                        <tr>
                            <td>运行环境</td>
                            <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                        </tr>
                        <tr>
                            <td>上传附件限制</td>
                            <td>{{ get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件" }}</td>
                        </tr>
                        <tr>
                            <td>服务器时间</td>
                            <td>{{ date('Y年m月d日 H时i分s秒') }}</td>
                        </tr>
                        <tr>
                            <td>服务器域名/IP</td>
                            <td>{{ $_SERVER['HTTP_HOST']}} [{{$_SERVER['SERVER_ADDR'] }}]</td>
                        </tr>
                        <tr>
                            <td>Host</td>
                            <td>{{ $_SERVER['REMOTE_ADDR'] }}</td>
                        </tr>
                        <tr>
                            <td>版本</td>
                            <td>v1.0.0</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </section>

    </div>
@endsection


