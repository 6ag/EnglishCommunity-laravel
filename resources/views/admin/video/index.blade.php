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
                    @if(is_object($errors) && count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    @endif
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <div class="row">
                            @foreach($videos as $key => $video)

                            @endforeach

                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">一共有{{ $videos->total() }}套视频</div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {{ $videos->links() }}
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


