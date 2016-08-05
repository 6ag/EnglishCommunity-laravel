@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                创建分类
                <small>新建分类</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">创建分类</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-warning">
                <div class="box-header with-border">
                    @include('layouts.Common.tips')
                </div>
                <div class="box-body">
                    <form role="form" action="{{ url('admin/category') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>分类名称</label>
                            <input type="text" class="form-control" placeholder="分类名称 例如: 语法" name="name">
                        </div>

                        <div class="form-group">
                            <label>分类别名</label>
                            <input type="text" class="form-control" placeholder="分类别名 例如: yufa" name="alias">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">创建分类</button>
                        </div>
                    </form>
                </div>

            </div>

        </section>

    </div>
@endsection


