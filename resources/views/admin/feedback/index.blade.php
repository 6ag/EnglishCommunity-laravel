@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                反馈信息管理
                <small>全部反馈信息列表</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">反馈信息管理</li>
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
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">ID</th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">联系方式</th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">内容</th>
                                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($feedbacks as $feedback)
                                        <tr role="row">
                                            <td>{{ $feedback->id }}</td>
                                            <td>{{ $feedback->contact }}</td>
                                            <td>{{ $feedback->content }}</td>
                                            <td>{{ $feedback->created_at }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">一共有{{ $feedbacks->total() }}个反馈信息</div>
                            </div>

                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {{ $feedbacks->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
            </div>

        </section>

    </div>
@endsection

