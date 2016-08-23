@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                远控推送管理
                <small>远程推送</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">远控推送管理</li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-header">
                    @include('layouts.Common.tips')
                </div>

                <div class="box-body">
                    <form role="form" action="{{ route('admin.video.send') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" value="{{ $videoInfo->title }}" name="title">
                            <input type="hidden" name="id" value="{{ $videoInfo->id }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="checkbox inline">
                                <input type="checkbox" name="info" value="1"> 推送视频
                            </label>
                        </div>

                        <div class="form-group col-md-12">
                            <textarea class="form-control" rows="3" placeholder="推送内容" name="push_content"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">立刻推送</button>
                        </div>
                    </form>
                </div>

            </div>

        </section>

    </div>
@endsection