@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="login">
        <div class="container">
            <h1 class="title tc">欢迎来到乐松</h1>
            <div class="login-box">
                <div class="form-control">
                    <i class="iconfont icon-mobilefill"></i>
                    <input name="telphone" type="text" placeholder="手机号/邮箱" v-model="username"/>
                </div>
                <div class="form-control">
                    <i class="iconfont icon-suo"></i>
                    <input name="pwd" type="password" placeholder="密码" v-model="pwd"/>
                </div>
                <div class="form-control btn-control">
                    <input type="button" value="登录" v-on:click="login">
                </div>
                <div class="tc" style="color: red;">
                    @{{ message }}
                </div>
                <div class="tr">
                    <a href="#">忘记密码</a>
                </div>
            </div>
            <div class="other-login">
                <p class="op-line tc">其他登录方式</p>
                <div class="tc login-logo">
                    <a href="#"><img src="{{ asset('lesong/images/login-wx.png') }}"> </a>
                    <a href="#"><img src="{{ asset('lesong/images/login-web.png') }}"></a>
                    <a href="#"><img src="{{ asset('lesong/images/login-qq.png') }}"></a>
                </div>

                <ul>
                    <li><a href="{{ url('lesong/act/index') }}">进入首页</a></li>
                    <li class="left-line"><a href="{{ url('lesong/user/regist') }}">注册</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                username:'',
                pwd: '',
                users_id : '',
                id : util.getStore('act_id'),
                userinfo:'',
                show_menu: false,
                message : ''
            },
            methods: {
                login: function(){
                    var self = this;
                    util.post(this,{
                        api: '{{url("api/user/login")}}',
                        data:{
                            phone : self.username,
                            pwd : self.pwd
                        }
                    }).then((res) => {
                        if(res.code == "200"){
                            var data = res.data;
                            self.userinfo = data;
                            util.setStore('userinfo',data);
                            window.location.href = "{{ url('lesong/user/index') }}";
                        }else{
                            self.message = res.msg;
                        }
                    });
                },
            }
        });
    </script>

@endsection