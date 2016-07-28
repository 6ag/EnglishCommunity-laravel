<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统 - 登录</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/blue.css') }}">

    <!--[if lt IE 9]>
    <script src="{{ url('assets/js/html5shiv.min.js') }}"></script>
    <script src="{{ url('assets/js/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">

@yield('content')

<script src="{{ url('assets/js/jquery-2.2.3.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ url('assets/js/icheck.min.js') }}"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>