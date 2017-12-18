@extends('lesong.layouts.app')
@section('style')
@endsection
@section('content')
    <div class="setting">
        <div class="container">
            <div class="row">
                关于徒步 <label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>
            </div>
            <div class="">
                &nbsp;
            </div>
            <!--<div class="row">-->
            <!--清除缓存 <label class="row-r-data">30.6M</label> <label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>-->
            <!--</div>-->
            <div class="row">
                免责申明 <label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>
            </div>
            <div class="row">
                反馈 <label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>
            </div>
            <div class="form-control btn-control btn-white">
                <input type="button" value="退出登录" class="btn-xl" v-on:click ="loginout">
            </div>
        </div>
    </div>
    @endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                abc: 'ddddd'
            },
            methods: {
                loginout: function(){
                    util.removeStore('userinfo');
                    window.location.href = '{{ url("lesong/user/login") }}';
                }
            }
        });
        //        app.getinfo();
    </script>

@endsection