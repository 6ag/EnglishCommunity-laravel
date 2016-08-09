@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                修改视频
                <small>修改当前视频信息</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">修改视频</li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-warning">
                <div class="box-header with-border">
                    @include('layouts.Common.tips')
                </div>

                <div class="box-body">
                    <form role="form" action="{{ route('admin.video.update', ['video' => $videoInfo->id]) }}" method="post">
                        {{ method_field('put') }}
                        {{ csrf_field() }}

                        <div class="row">
                            {{-- 名称 --}}
                            <div class="form-group col-md-5">
                                <input type="text" class="form-control" placeholder="教程名称" name="title" value="{{ $videoInfo->title }}">
                            </div>

                            {{-- 讲师 --}}
                            <div class="form-group col-md-2">
                                <input type="text" class="form-control" placeholder="讲师" name="teacher" value="{{ $videoInfo->teacher }}">
                            </div>

                            <!-- 分类 -->
                            <div class="form-group col-md-1">
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $videoInfo->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 来源 --}}
                            <div class="form-group col-md-2">
                                <label><input type="radio" class="radio-inline" name="type" value="youku" {{ $videoInfo->type == 'youku' ? 'checked' : '' }}> 优酷 </label> |
                                <label><input type="radio" class="radio-inline" name="type" value="tudou" {{ $videoInfo->type == 'tudou' ? 'checked' : '' }}> 土豆 </label>
                            </div>

                            {{-- 推荐 --}}
                            <div class="form-group col-md-2">
                                <label class="checkbox inline">
                                    <input type="checkbox" name="recommend" value="1"> 推荐
                                </label>
                            </div>
                        </div>

                        {{-- 图片 --}}
                        <div class="row">
                            {{-- 上传图片控件 --}}
                            <div class="form-group col-md-12">
                                <input id="file_upload" type="file" multiple="true">
                                <script src="{{ url('vendor/uploadifive/jquery.uploadifive.min.js') }}" type="text/javascript"></script>
                                <link rel="stylesheet" type="text/css" href="{{ url('vendor/uploadifive/uploadifive.css') }}">
                                <script type="text/javascript">
                                    $(function() {
                                        $('#file_upload').uploadifive({
                                            'auto' : true,
                                            'debug' : false, // 是否开启浏览器调试
                                            'fileTypeExts':'*.jpg;*.gif;*.bmp;*.png;*.jpeg', //允许的图片类型
                                            'buttonText' : '选择图片',
                                            'successTimeout' : 300,
                                            'uploadLimit' : 100,
                                            'formData' : {
                                                '_token' : '{{ csrf_token() }}'
                                            },
                                            'uploadScript' : '{{ route('admin.upload') }}',
                                            'onUploadComplete' : function(file, imagePath) {
                                                // 赋值给隐藏域
                                                $('input[name=photo]').val(imagePath);
                                                $('#thumbnail').attr('src', '/' + imagePath);
                                                $('#thumbnail').show();

                                                // 设置提交表单按钮可用
                                                $('#submit').attr('disabled', false);
                                            },
                                            onUpload : function(file) {
                                                // 设置提交表单按钮不可用
                                                $('#submit').attr('disabled', true);
                                            },
                                        });
                                    });
                                </script>
                            </div>

                        </div>

                        <div class="row">
                            {{-- 显示缩略图 --}}
                            <div class="form-group col-md-3">
                                <input type="hidden" name="photo" value="{{ $videoInfo->photo }}">
                                <img src="{{ url($videoInfo->photo) }}" alt="" id="thumbnail" name="photo" style="height: 150px;">
                            </div>
                        </div>

                        {{-- 简介 --}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" rows="3" placeholder="教程简介" name="intro">{{ $videoInfo->intro }}</textarea>
                            </div>
                        </div>

                        {{-- 视频列表 --}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" rows="20" placeholder="教程地址列表格式: 标题,地址/id" name="video_urls">{{ $video_urls }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-2">
                                <button id="submit" type="submit" class="btn btn-primary btn-block btn-flat">提交到数据库</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </section>

    </div>
@endsection


