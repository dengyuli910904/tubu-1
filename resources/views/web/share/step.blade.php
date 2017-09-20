@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <style type="text/css">
    body{ background: #fff; margin: 0 auto; padding: 0;}
    section{ 
        /*position: absolute;*/
        left: 0;
        top: 0;
        text-align: center;
        width: 100%;
        height: 50%;
    }
    .ring{ background: url('{{ asset("web/img/ring.png")}}');
        background-repeat: no-repeat;
        background-position: center;
        width: 100%;
        height: 300px;
        background-size: contain;
        /*left: 50%;*/
        left: 0;
        top: 20px;
        /*margin-left: -188px;*/
        position: absolute;
    }
    .ring-content{
        width: 200px;
        height: 200px;
        overflow: hidden;
        margin:0 auto;
        padding:0;
        text-align: center;
        /*border:1px solid blue;*/
        margin-top: 50px;
    }
    h2{ margin-top: 50px;}
    h2 .count{ font-size: 45px; font-weight: 800; line-height: 50px; margin-top: 20px;}
    h3{ font-weight: 800;}
    .userinfo{ position: absolute; left:0; width: 100%; top: 65%; }
    .user-img img{ border: 3px solid rgb(17,143,0); max-width: 100px;}
    </style>
@endsection
@section('content')
    <div>
        <section>
            <div class="ring">
                <div class="ring-content">
                    <h2><span class="count"><i>{{$data['step']['count']}}</i></span> 步</h2>
                    <h3>{{$data['step']['use_time']}}</h3>
                    <p>用时</p>
                </div>
            </div>
        </section>
        <section class="userinfo">
            <div class="user-img">
                <img src="{{$data['user']['headimg']}}" class="img-circle user-img">
            </div>
            <h4><b>{{$data['user']['name']}}</b></h4>
            <p>{{$data['step']['date']}}</p>
        </section>
    </div>
@endsection
@section('scripts')
     <script type="text/javascript">
    //  var h =  document.body.clientHeight;
    //  $('.footer').css('top',h-40);
     </script>
@endsection