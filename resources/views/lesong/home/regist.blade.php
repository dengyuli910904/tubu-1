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
                    <input name="telphone" type="text" placeholder="手机号" style="width: 50%" maxlength="11" v-model="mobile"/>
                    <label class="bg-green" style=" position: absolute; right: 15px;" v-on:click="getcode">获取验证码</label>
                </div>
                <div class="form-control">
                    <i class="iconfont icon-iconfont5"></i>
                    <input name="pwd" type="text" placeholder="验证码" v-model="code"/>
                </div>
                <div class="form-control">
                    <i class="iconfont icon-suo"></i>
                    <input name="pwd" type="password" placeholder="密码" v-model="pwd"/>
                </div>
                <div class="form-control btn-control">
                    <input type="button" value="注册" v-on:click="regist">
                </div>
                {{--<div class="form-control btn-control">--}}
                    {{--<input type="button" value="登录" v-on:click="login">--}}
                {{--</div>--}}
                {{--<div class="tc pd-t-50">--}}
                    {{--<a href="#">邮箱注册</a>--}}
                {{--</div>--}}
            </div>

        </div>
    </div>
    @endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                mobile: '',
                code: '',
                pwd: '',
                code_id:'5d1d5970-d4df-11e7-af05-01ae67e82114',
            },
            methods: {
                regist: function(){
                    var self = this;
                    if(!self.mobile){
                        alert('请输入正确的手机号码！');
                    }
                    util.post(this,{
                        api: '{{ url('api/user/register') }}',
                        data: {
                            code_id : self.code_id,
                            code : self.code,
                            phone: self.mobile,
                            pwd: self.pwd
                        }
                    }).then((res) => {
                        if(res.code == 200){
                            util.setStore('userinfo',res.data);
                            window.location.href = "{{ url('lesong/act/index') }}";
                        }
                    });
                },
                getcode: function(){
                    var self = this;
                    if(!self.mobile){
                        alert('请输入正确的手机号码！');
                    }
                    util.post(this,{
                        api: '{{ url('sendsms') }}',
                        data: {
                            phone: self.mobile,
                            type : 3
                        }
                    }).then((res) => {
                        if(res.code == 200){
                            self.code_id = res.data.id;
                            alert(res.msg);
                        }
                    });
                }
            }
        });
//        app.getinfo();
    </script>

@endsection