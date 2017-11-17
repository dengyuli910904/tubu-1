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

        section{ padding: 50px 0px 50px 0px;}
        .title h3{ padding:50px 0px;}

        section ul{text-align: left; width: 100%; padding: 0; margin: 0; position: relative;}
        section ul li{ padding:20px 0px; text-align: left; width: 100%;
            float: left;}
        section ul li:after{
            content: '';
            height:35px;
            width: 100%;
            border-bottom: 1px solid #e6e6e6;
            /*background: #000;*/
            left:0;
            position: absolute;
        }
        .star-list { font-size: 26px; color: #ffb300;}

        footer{ background: #118f00; line-height: 40px; color: #fff;}
        footer p{ margin: 0px;}

        h3{ color: #666666;}
        .msg-star{ font-size: 25px; color: #ffb300; line-height: 40px;}
        .msg-time{ float: right; line-height: 40px; font-size: 12px;}
        .msg-text{ line-height: 35px;}
        .btn-default{ background: #118f00; border: 1px solid #118f00; color: #fff;}
        .btn-default:hover{ background: #118f00; border: 1px solid #118f00; color: #fff;}
    </style>
@endsection
@section('content')
    <header>
        <div class="container">
            <div class="row title">
                <div class="col-md-6">
                    <a href="{{ url('/') }}"><img src="{{ asset('web/img/logo-w.png') }}"><span>乐松</span> </a>
                </div>
                <div class="col-md-6">
                    <nav>
                        <ul>
                            <li><a href="#">留言榜</a></li>
                            <li><a href="#">发布活动</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <form method="post" action="{{ url('msg/store') }}">
                <div class="row">
                    <p class="star-list" id="star">
                        <i class="fa fa-star" value="1" id="1" aria-hidden="true"></i>
                        <i class="fa fa-star-o" value="2" id="2" aria-hidden="true"></i>
                        <i class="fa fa-star-o" value="3" id="3" aria-hidden="true"></i>
                        <i class="fa fa-star-o" value="4" id="4" aria-hidden="true"></i>
                        <i class="fa fa-star-o" value="5" id="5" aria-hidden="true"></i>
                    </p>
                    <textarea name="content" class="form-control" rows="4"></textarea>
                    <input type="hidden" value="1" name="starnum" id="starnum">
                </div>
                <div class="row t-r pd-t-20">
                    <button class="btn btn-default" type="submit">发表</button>
                </div>
            </form>
        </div>
    </section>
    <section>
        <div class="container">
            {{--<div class="row">--}}

            {{--</div>--}}
            <div class="row">
                <h5>全部评论 <span>{{ $count }}</span></h5>
                <ul>
                    @foreach($data as $item)
                    <li>
                        <div>
                            <span class="msg-star">
                                @for($i=1;$i<=5;$i++)
                                    <i class="fa {{ $i<=$item->starnum?'fa-star':'fa-star-o'}}" aria-hidden="true"></i>
                                @endfor
                                {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                {{--<i class="fa fa-star" aria-hidden="true"></i>--}}
                                {{--<i class="fa fa-star-o" aria-hidden="true"></i>--}}
                                {{--<i class="fa fa-star-o" aria-hidden="true"></i>--}}
                            </span>
                            <span class="msg-time">
                                {{ $item->created_at }}
                            </span>
                        </div>
                        <div class="msg-text">
                           {{$item->content}}
                        </div>
                    </li>
                        @endforeach

                </ul>
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
        $('#star i').click(function(){
            var value = $(this).attr('value');
            $('#starnum').val(value);

            $('#star i').removeClass('fa-star').addClass('fa-star-o');
            $('#star i').each(function(index,e){
                if(index <= (value-1)){
                    $(e).removeClass('fa-star-o').addClass('fa-star');
                }
            });
//           alert($(this).attr('value'));
        });
    </script>
@endsection