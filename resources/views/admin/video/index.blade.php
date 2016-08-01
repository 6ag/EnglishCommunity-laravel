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
                            @foreach($videoInfos as $key => $videoInfo)

                            @endforeach

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


