@extends('web.layouts.pc')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <style type="text/css">
        body{ background: #fff; font-family: "Microsoft YaHei UI";}
        .container{ width: 960px;}

        .pd-20{ pdding-top:20px;}
        .pd-t-20{ padding-top: 20px;}
        .pd-t-100{ padding-top:110px;}
        .pd-t-80{ padding-top: 80px;}
        .t-r{ text-align: right;}
        .t-c{ text-align: center;}
        .t-l{ text-align: left;}
        ul li{ list-style: none; float: left;}

        header{ background: url('{{ asset("web/img/header_bg.png") }}') no-repeat; background-size: 100%;}
        header .title { padding:20px 5px;}
        header .title a{ color: #fff; font-size: 16px;}
        header .title a:hover{ text-decoration: none;}
        header .title a span{ font-size: 25px; padding: 0 10px; font-weight: 800;}

        header .title nav{ width: 100%; text-align: right;}
        nav ul li{ list-style: none; float: right;}
        nav ul li a{ padding: 10px 25px; line-height: 25px;}

        h1{ color: #fff; font-size: 45px; font-weight: 900; line-height: 70px;}

        .android { background: #ff8914; color: #fff; padding: 8px 18px; border-radius: 20px; margin-right: 20px; font-size: 15px;}
        .android:hover,.iphone:hover{ cursor: pointer; text-decoration: none;}
        .android:hover{ color:#FFF;}
        .iphone:hover{ color: #118f00;}
        .iphone{ background: #fff; color: #118f00;  padding: 8px 18px; border-radius: 20px; font-size: 15px;}
        section{ padding: 100px 0px 150px 0px;}
         /*section.part_1 { padding:100px 0px 130px 0px;}*/
         /*section.part_3 { padding: 100px 0px 30px 0px;}*/
        .title h3{ padding:50px 0px;}

        .intro{ font-size:15px; line-height: 25px; clear: both;}
        section ul{text-align: left; width: 100%; padding: 0; margin: 0;}
        section ul li{ padding:20px 20px 20px 0px; text-align: left; float: left;}

        .download .square{ text-align: center; margin: 0 auto;}
        .square{ width: 150px; height: 150px; text-align: center; border:1px solid #118f00; padding: 10px; color: #118f00;}
        .square.current{ background: #118f00; color: #fff;}
        .square .fa{ font-size: 50px; margin-top: 30px;}
        .square p{ margin: 0 auto; padding: 0; clear: both; text-align: center;}
        footer{ background: #118f00; line-height: 40px; color: #fff;}
        footer p{ margin: 0px;}

        h3{ color: #666666;}
        .part_3 p,.part_2 p { color: #666666;}
        .part_1{ background: url('{{ asset("web/img/boot_1.png") }}') repeat-x; background-position: center bottom;}
        .part_2{ border-bottom: 1px solid #e6e6e6;}
        .part_3{ background: url('{{ asset("web/img/boot_2.png") }}') repeat-x; background-position: center 65%;}
        .download{ background: #f5f5f5;}

        /*右侧悬浮*/
        .honey-feedback-floatbtn {
            display: inline-block;
            position: fixed;
            right: 40px;
            top: 500px;
            z-index: 9000;
        }
        .honey-feedback-floatbtn .honey-feedback-list {
            width: 50px;
            float: right;
        }
        .honey-feedback-floatbtn .honey-feedback-list li a{
            text-align: center;
            width: 100%;
            color: #fff;
        }
        .honey-feedback-floatbtn .honey-feedback-list li{
            width: 50px;
            height:50px;
            text-align: center;
        }
        .honey-feedback-floatbtn .honey-feedback-list li i{
            line-height: 50px;
            font-size: 25px;
        }
        .honey-feedback-floatbtn .honey-feedback-list li.leave-msg{
            background: #118f00;

        }
        .honey-feedback-floatbtn .honey-feedback-list li.to-top{
            background: #e6e6e6;
        }
    </style>
@endsection
@section('content')
    <div class="honey-feedback-floatbtn clearfix">
        <ul class="honey-feedback-list">
            <li class="leave-msg">
                <a href="{{ url('/msg') }}" class="col-xs-11"><i class="fa fa-comment" aria-hidden="true"></i></a>
            </li>
            <li class="to-top">
                <a href="#top" class="col-xs-11"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
            </li>
        </ul>
    </div>
    <header id="top">
        <div class="container">
            <div class="row title">
                <div class="col-md-6">
                    <a href="{{ url('/') }}"><img src="{{ asset('web/img/logo-w.png') }}"><span>乐松</span> </a>
                </div>
                <div class="col-md-6">
                   <nav>
                       <ul>
                           <li><a href="{{ url('/msg') }}">留言榜</a></li>
                           <li><a href="#">发布活动</a></li>
                       </ul>
                   </nav>
                </div>
            </div>
            <div class="row pd-t-80">
                <div class="col-md-6">
                    <img src="{{ asset('web/img/slogen.png') }}" class="img-responsive" style="width: 400px;">
                    <p class="pd-t-80">
                        <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.livesong.travel" target="_blank" class="android"><i class="fa fa-android" aria-hidden="true"></i> Android</a>
                        <a href="#" class="iphone"><i class="fa fa-apple" aria-hidden="true"></i> Iphone</a>
                    </p>
                </div>
                <div class="col-md-6 t-r">
                    <img src=" {{ asset('web/img/pic_1.png') }}" class="img-responsive" style="width: 350px; float:right;">
                </div>
            </div>
        </div>
    </header>
    <section class="part_1">
        <div class="container">
            <div class="title t-c">
                <h3>聚集世界每个角落，乐享乐松！</h3>
            </div>
            <div class="row t-c">
                <img src="{{ asset('web/img/pic_4.png') }}">
            </div>
        </div>
    </section>
    <section class="part_2">
        <div class="container">
            <div class="row">
                <div class="col-md-7 t-l">
                    <img src="{{ asset('web/img/pic_2.png') }}"/>
                </div>
                <div class="col-md-5">
                    <div class="title">
                        <h3>聚集世界每个角落，乐享乐松！</h3>
                    </div>
                    <p class="intro">
                        一起同行<br/>
                        与环球徒友约定<br/>
                        我们共享欢乐！
                    </p>
                    <ul class="pd-t-80">
                        <li><a href="javascript:void(0);"><img src="{{ asset('web/img/fun.png') }}"> </a></li>
                        <li><a href="javascript:void(0);"><img src="{{ asset('web/img/love.png') }}"> </a></li>
                        <li><a href="javascript:void(0);"><img src="{{ asset('web/img/life.png') }}"> </a></li>
                    </ul>
                    <p class="intro">分享徒步乐趣，拥有一个好心情，记录你的生活</p>
                </div>
            </div>
            {{--<div class="title">--}}
                {{--<h3>聚集世界每个角落，乐享乐松！</h3>--}}
            {{--</div>--}}
            {{--<div class="row t-c">--}}
                {{--<img src="{{ asset('web/img/pic_4.png') }}">--}}
            {{--</div>--}}
        </div>
    </section>
    <section class="part_3">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="title">
                        <h3>见证快乐，共享徒行盛宴！</h3>
                    </div>
                    <p class="intro">
                        有好的个人管理<br/>
                        分享活动乐趣<br/>
                        丰富你的生活
                    </p>

                </div>
                <div class="col-md-7 t-r">
                    <img src="{{ asset('web/img/pic_3.png') }}"/>
                </div>
            </div>
        </div>
    </section>
    <section class="download">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="square current">
                        <p><i class="fa fa-android" aria-hidden="true"></i></p>
                        <p>Android下载</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="square">
                        <p><i class="fa fa-apple" aria-hidden="true"></i></p>
                        <p>IPhone下载</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="square t-c">
                        <p  style=" width: 100%;">
                            <img src="{{ asset('web/img/code.png') }}" width="90%" height="90%"/>
                        </p>
                        <p>二维码下载</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row t-c">
                <p>Copyright@2017,livesong.cn allRights Reserved  粤ICP备1752333号</p>
            </div>
        </div>
    </footer>
@endsection
@section('scripts')
    <script type="text/javascript">
        // 	var h =  document.body.clientHeight;
        // 	$('.footer').css('top',h-40);
    </script>
@endsection