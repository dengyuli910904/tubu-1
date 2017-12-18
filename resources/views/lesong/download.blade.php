@extends('lesong.layouts.app')
@section('style')
    <style>
        .float-bg{
            overflow: hidden;
            width: 100%;
            background-color: #000; background-color: rgba(0,0,0,0.3); position: fixed; top: 0; bottom: 0; left:0; filter:Alpha(opacity=50);}
        .float-bg .icon-raw{ position: fixed; right: 10px;
            top:10px; height: 150px; width: 50%;}
        .float-bg h1{ position: fixed; width: 150px; text-align: center; color: #fff; left: 50%; margin-left: -75px; top: 35%;}
        .float-bg .download { position: fixed;
            top:50%; text-align: center; width: 100%;}
        .float-bg .download input{ width: 100px; border-radius: 5px; line-height: 30px; color: #fff; background: #118f00; font-size: 15px; z-index: 10001;}
        .float-bg .ios-msg{ position: fixed; text-align: center; width: 100%;top:40%; font-size: 16px;}
    </style>
@endsection
@section('content')
    <div class="float-bg">
        <div class="icon-raw">
            <img src="{{ asset('lesong/images/raw.png') }}" class="img-responsive"/>
            <h1>请从浏览器打开</h1>
        </div>
        <div class="ios-msg">

        </div>
        <div class="download">
            <input class="btn-download" value="点击下载" type="button" onclick="download()">
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function(){
            $('.icon-raw').hide();
            $('.ios-msg').hide();
            var b = getBrowser();
            if(b == 'wx'){
                $('.icon-raw').show();
            }else if( b == 'ios'){
                $('.ios-msg').html('Ios版本正在开发当中，敬请期待');
                $('.download').hide();
                $('.ios-msg').show();
            }else{
                $('.download').show();
            }
        }
        function download(){
            var url = getaddress();
            alert(url);
            window.location.href = url;
        }
        function getBrowser(){
            var ua = window.navigator.userAgent.toLowerCase();//微信
            var u = navigator.userAgent;//手机类型android或ios
            if(ua.match(/MicroMessenger/i) == 'micromessenger') {
                return 'wx';
            }else if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
                return 'android';
            }else if (u.indexOf('iPhone') > -1) {//苹果手机
                return 'ios';
            }else {
                alert("其他系统手机不支持客邦APP(客邦app只支持ios和安卓系统的手机)");
            }
        }
        function getaddress (){
            var download_address = '';//下载地址
            var ua = window.navigator.userAgent.toLowerCase();//微信
            var u = navigator.userAgent;//手机类型android或ios
            if(ua.match(/MicroMessenger/i) == 'micromessenger'){//微信
                //如果是微信下载地址跳转到腾讯应用宝
                download_address = 'http://android.myapp.com/myapp/detail.htm?apkName=com.livesong.travel&ADTAG=mobile';
            }else if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
                download_address = 'http://tubu.api.livesong.cn/lesong/com.livesong.travel-2017-11-08.apk';
            } else if (u.indexOf('iPhone') > -1) {//苹果手机
                download_address ='#';
            } else {
                alert("其他系统手机不支持客邦APP(客邦app只支持ios和安卓系统的手机)");
            }
            return download_address;
        }

        {{--var app = new Vue({--}}
            {{--el: '#app',--}}
            {{--data:{--}}
                {{--type: 0,// 0 主页，1 活动提醒消息，2 角色认领消息， 3 评价消息--}}
                {{--userinfo : util.getStore('userinfo'),--}}
                {{--list: [],--}}
            {{--},--}}
            {{--methods: {--}}
                {{--getlist: function(){--}}
                    {{--var self = this;--}}
                    {{--if(!self.userinfo){--}}
                        {{--alert('请先登录！');--}}
                        {{--window.location.href = "{{ url('lesong/user/login') }}";--}}
                    {{--}--}}
                    {{--util.get(this,{--}}
                        {{--api: '{{url("api/user/systemmsg")}}?users_id='+self.userinfo.id--}}
                    {{--}).then((res) => {--}}
                        {{--var data = res.data;--}}
                    {{--data.forEach(function(value, index,array){--}}
                        {{--self.list.push(value);--}}
                    {{--});--}}
                {{--});--}}
                {{--},--}}
                {{--showmesg: function(type){--}}
                    {{--var self = this;--}}
                    {{--self.type = type;--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
    </script>
@endsection