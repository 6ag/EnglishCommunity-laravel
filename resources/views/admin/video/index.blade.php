@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                视频管理
                <small>全部视频列表</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">视频管理</li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-header">
                    @include('layouts.Common.tips')
                </div>

                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <div class="row">
                            <form action="" method="get">
                                <div class="col-md-2">
                                    <select class="form-control" name="category_id">
                                        <option value="0">所有分类</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ (isset($currentCategory) && $currentCategory->id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-danger">筛选</button>
                                </div>
                            </form>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="col-md-1" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">ID</th>
                                        <th class="col-md-4" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">标题</th>
                                        <th class="col-md-1" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">来源</th>
                                        <th class="col-md-2" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">最后更新时间</th>
                                        <th class="col-md-2" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($videoInfos as $videoInfo)
                                        <tr role="row">
                                            <td>{{ $videoInfo->id }}</td>
                                            <td>{{ $videoInfo->title }}</td>
                                            <td>{{ $videoInfo->type }}</td>
                                            <td>{{ date('Y-m-d H:i:s', $videoInfo->updated_at->timestamp) }}</td>
                                            <td>
                                                <a href="{{ route('admin.video.push', ['video' => $videoInfo->id]) }}">推送</a> |
                                                <a href="{{ route('admin.video.edit', ['video' => $videoInfo->id]) }}">编辑</a> |
                                                <a href="javascript:;" onclick="deleteVideoInfo({{ $videoInfo->id }})">删除</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">一共有{{ $videoInfos->total() }}套视频</div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {{ $videoInfos->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>

    </div>
@endsection

<script>

    function deleteVideoInfo(id) {
        //询问框
        layer.confirm('您确定要删除这个教程集吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{ url('admin/video')}}/" + id, {'_token' : '{{csrf_token()}}', '_method' : 'delete'}, function(data) {
                if (data.status == 1) {
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
                window.location.reload();
            });
        }, function(){

        });
    }
</script>

