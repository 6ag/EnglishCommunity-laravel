@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                配置管理
                <small>全部配置列表</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">配置管理</li>
            </ol>
        </section>

        <section class="content">

            <div class="box">
                <div class="box-header">
                    @include('layouts.Common.tips')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">ID</th>
                                        <th style="width: 15%;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">配置名称</th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">配置内容</th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">备注</th>
                                        <th style="width: 12%;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($options as $option)
                                        <form role="form" action="{{ url('admin/option/' . $option->id) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <tr role="row">
                                                <td>{{ $option->id }}</td>
                                                <td><input style="width: 100%;" class="form-control" type="text" value="{{ $option->name }}" name="name"></td>
                                                <td><input style="width: 100%;" class="form-control" type="text" value="{{ $option->content }}" name="content"></td>
                                                <td><input style="width: 100%;" class="form-control" type="text" value="{{ $option->comment }}" name="comment"></td>
                                                <td><button type="submit" class="btn btn-info">修改</button>&nbsp;&nbsp;&nbsp;&nbsp;<a  class="btn btn-danger" href="javascript:;" onclick="deleteOption({{$option->id}})">删除</a></td>
                                            </tr>
                                        </form>
                                    @endforeach

                                    </tbody>
                                </table>
                                <a class="btn btn-bitbucket" href="javascript:;" onclick="addOption()">新增一项配置</a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </section>

    </div>
@endsection

<script>
    function deleteOption(id) {
        layer.confirm('您确定要删除这个配置项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/option')}}/" + id, {'_token' : '{{ csrf_token() }}', '_method' : 'delete'}, function(data) {
                if (data.status == 1) {
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
                window.location.reload();
            });
        }, function(){
            // 取消
        });
    }

    function addOption() {
        layer.confirm('您确定要新增一个配置项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/option')}}", {'_token' : '{{ csrf_token() }}', '_method' : 'post'}, function(data) {
                window.location.reload();
            });
        }, function(){
            // 取消
        });
    }
</script>

