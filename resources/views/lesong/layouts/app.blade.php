<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Live Song</title>
    <META HTTP-EQUIV="Expires" CONTENT="0">

    <meta name="author" content="www.livesong.cn">
    <meta name="distribution" content="Global">
    <meta name="robots" content="all">
    <link href="{{ asset('lesong/css/common.css?12222')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('lesong/css/lesong.css?rand=<script type="text/javascript">Math.random()</script>')}}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('lesong/js/jquery-1.7.2.min.js')}}"></script>
    <!--[if IE]>
    <script src="js/html5.js"></script>
    <![endif]-->
    @yield('style')
</head>
<body>
<div class="main" id="app">
    @yield('content')
</div>

<script src="{{ asset('lesong/js/public.js') }}"></script>
<script src="{{ asset('lesong/js/config.js') }}"></script>
<script src="{{ asset('lesong/js/util.js') }}"></script>
<script src="{{ asset('lesong/js/vue.min.js') }}"></script>
    @yield('script')
</body>
</html>