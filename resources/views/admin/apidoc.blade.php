@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                API文档
                <small>API文档</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 仪表盘</a></li>
                <li class="active">API文档</li>
            </ol>
        </section>

        <iframe src="{{ url('apidoc') }}" frameBorder=0 width="100%" height="1000px"></iframe>

    </div>
@endsection
