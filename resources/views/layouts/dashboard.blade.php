<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/skin-blue.min.css') }}">

    <!--[if lt IE 9]>
    <script src="{{ url('assets/js/html5shiv.min.js') }}"></script>
    <script src="{{ url('assets/js/respond.min.js') }}"></script>
    <![endif]-->

    <script src="{{ url('assets/js/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/app.min.js') }}"></script>
    <script src="{{ url('vendor/layer/layer.js') }}"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('layouts.Common.header')

    @include('layouts.Common.sidebar')

    @yield('content')

    @include('layouts.Common.footer')
</div>

</body>
</html>
