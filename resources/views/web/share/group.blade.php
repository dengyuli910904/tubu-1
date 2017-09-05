@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <style type="text/css">
    body{ background: #f5f2f2;}
    .row{ padding:5px 15px;}
    .user-img{ width: 45px;}
    .container{ padding: 0; max-width: 736px;}
    h3{ color: #333; margin:0px 0px;}
    section { margin: 0 0 10px 0; background: #fff; width: 100%; padding: 0;}
    section h4{ font-size: 15px; line-height: 20px; color: #999;}
    .act_group{ padding-left: 0px;}
    h4.act_title{
        color: #999;
    }
    h4.act_title:before{
        content: '';
        width: 0;
        height: 0;
    }
    section h4:before{ 
            display: inline-block;
            left: 0;
            content: '';
            position: relative;
            height: 15px;
            width: 2px;
            top: 0;
            background: #119100;
            margin:-2px 10px;
    }
    hr{ margin-top: 5px; margin-bottom: 5px;}
    .footer{ text-align: center; height: 40px; font-size: 17px; 
        width: 100%;position:fixed;left: 0; bottom: 0; 
        background: #119100; color: #fff; line-height: 30px; margin: 0; overflow: hidden;}
    h4.head,.g-head h4{
        font-size: 17px;
        color: #333;
    }
    .g-head{
        text-align: center;
    }
    .g-head h4:before,h4.head:before{
        width: 0;
        height: 0;
        margin: 0;
    }
    .g-head .item:before{
        width: 1px;
        height: 20px;
        background: red;
        display: block;
    }
    .act-list h5{
        margin: 3px auto;
    }
    .act-list .row:before{
        width: 100%;
        content: '';
        height: 1px;
        left: 0;
        display: block;
        background: #eee;
        margin-bottom: 10px;
    }
    .act-list .row:after{
        content: '';
        margin: 0px;
    }
    </style>
@endsection
@section('content')
    <div>
        <section>
            <div class="row" style="text-align:center;">
                <img src="{{ asset('web/img/user.png')}}" class="img-rounded" style=" margin:20px auto;"/>
                <h4  class="head">深圳湾徒步旅行团</h4>
                <p>
                    <span>深圳南山</span>
                </p>
            </div>
            <div class="row g-head">
                <div class="col-xs-4 item">
                    <h4>14</h4>
                    <p>等级</p>
                </div>
                <div class="col-xs-4 item">
                    <h4>530</h4>
                    <p>人数</p>
                </div>
                <div class="col-xs-4 item">
                    <h4>325</h4>
                    <p>关注</p>
                </div>
            </div>
         
            <hr/>
            <div class="row">
                <h4>简介</h4>
                <div class="col-xs-12">
                    徒步旅行，迈开新自我！
                </div>
            </div>
            <hr/>
            <div class="row">
                <h4>创建时间</h4>
                <div class="col-xs-12">
                    2017-09-04
                </div>
            </div>
        </section>
        
        <section>
            <div class="row">
                <div class="col-xs-2 leader">
                    <img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
                </div>
                <div class="col-xs-2">
                    <img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
                </div>
                <div class="col-xs-2">
                    <img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
                </div>
                <div class="col-xs-2 add">
                    <img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
                </div>
                <div class="col-xs-4" style="line-height:50px;">
                    120/200人
                </div>
                <!-- <div class="col-xs-1">
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"  style="line-height:50px;"></span>
                </div> -->
            </div>

        </section>

        <section style=" margin-bottom:50px;">
            <div class="row">
                <h4>俱乐部活动</h4>
            </div>
            <!-- <hr/> -->
            <div class="act-list">
                <div class="row">
                    <div class="col-xs-5">
                        <img src="{{ asset('web/img/img.png')}}" class="img-rounded img-responsive">
                    </div>
                    <div class="col-xs-7">
                        <h5>深圳换了徒步下机型</h5>
                        <p>
                            <span class="label label-warning">即将开始</span>
                            <span class="label label-danger">徒步</span>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-user">120</span>
                        </p>
                        <p>2017-09-03</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <img src="{{ asset('web/img/img.png')}}" class="img-rounded img-responsive">
                    </div>
                    <div class="col-xs-7">
                        <h5>深圳换了徒步下机型</h5>
                        <p>
                            <span class="label label-warning">即将开始</span>
                            <span class="label label-danger">徒步</span>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-user">120</span>
                        </p>
                        <p>2017-09-03</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        <img src="{{ asset('web/img/img.png')}}" class="img-rounded img-responsive">
                    </div>
                    <div class="col-xs-7">
                        <h5>深圳换了徒步下机型</h5>
                        <p>
                            <span class="label label-warning">即将开始</span>
                            <span class="label label-danger">徒步</span>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-user">120</span>
                        </p>
                        <p>2017-09-03</p>
                    </div>
                </div>
            </div>
        </section>
       

        <!-- <section>
            <p>留言</p>
        </section> -->

        <section class="footer">
            <div class="row">
                    申请加入
            </div>
            <!-- <div class="col-xs-7">
                <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </div>
            <div class="col-xs-5">报名</div> -->
        </section>
    </div>
@endsection
@section('scripts')
     <script type="text/javascript">
    //  var h =  document.body.clientHeight;
    //  $('.footer').css('top',h-40);
     </script>
@endsection