@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="message">
        <div class="msg-items">
            <ul v-if="type == 0 ">
                <li>
                    <div>
                        <img src="{{ asset('lesong/images/intention-msg.png') }}" class="img-head"/>
                    </div>
                    <div class="msg-header">
                        <p>
                            <span class="username">活动提醒</span>
                            <a href="javascript:void(0);" v-on:click="showmesg(1)" class="link-url"><i class="iconfont icon-red-dot"></i> <i class="iconfont icon-xiangyou1"></i></a>
                        </p>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="{{ asset('lesong/images/role-msg.png') }}" class="img-head"/>
                    </div>
                    <div class="msg-header">
                        <p>
                            <span class="username">角色认领</span>
                            <a href="javascript:void(0);" v-on:click="showmesg(2)" class="link-url"><i class="iconfont icon-red-dot"></i> <i class="iconfont icon-xiangyou1"></i> </a>
                        </p>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="{{ asset('lesong/images/comment-msg.png') }}" class="img-head"/>
                    </div>
                    <div class="msg-header">
                        <p>
                            <span class="username">评价消息</span>
                            <a href="javascript:void(0);" v-on:click="showmesg(3)" class="link-url"><i class="iconfont icon-red-dot"></i> <i class="iconfont icon-xiangyou1"></i> </a>
                        </p>
                    </div>
                </li>
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="msg-header">--}}
                        {{--<p> <span class="username">留言消息</span><a href="#" class="link-url"><i class="iconfont icon-red-dot"></i> <i class="iconfont icon-xiangyou1"></i> </a></p>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="msg-header">--}}
                        {{--<p> <span class="username">总结消息</span><a href="#" class="link-url"><i class="iconfont icon-red-dot"></i> <i class="iconfont icon-xiangyou1"></i> </a></p>--}}
                    {{--</div>--}}
                {{--</li>--}}


            </ul>
            <ul>
                <li v-for="(item,index) in list">
                    <div>
                        <img v-bind:src="item.headimg" class="img-head"/>
                    </div>
                    <div class="user-content">
                        <p>
                            <span class="username">@{{ item.name }}</span>
                            <span class="min-tag tag-sex-female" v-if="type != 2"><i class="iconfont icon-female"></i> @{{ item.age }}</span>
                            <a href="#" v-if=" type == 2 && item.is_pass == 0" v-on:click="role_pass(item.id,item.activities_id,item.users_id,index)" class="btn btn-pass">@{{ item.btn_str }}</a>
                            <a href="#" v-if=" type == 2 && item.is_pass == 1"  class="btn">已通过</a>
                        </p>
                        <p>@{{ item.content }}</p>
                    </div>
                </li>
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="user-content">--}}
                        {{--<p>--}}
                            {{--<span class="username">lily</span><span class="min-tag tag-sex-male"><i class="iconfont icon-male"></i> 24</span>--}}
                            {{--<a href="#" class="btn btn-pass">通过</a>--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--申请领取深圳湾徒步下机型后勤职务--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="user-content">--}}
                        {{--<p>--}}
                            {{--<span class="username">lily</span><span class="min-tag tag-sex-female"><i class="iconfont icon-female"></i> 24</span>--}}
                            {{--<a href="#" class="btn btn-pass">通过</a>--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--申请领取深圳湾徒步下机型后勤职务--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="user-content">--}}
                        {{--<p>--}}
                            {{--<span class="username">lily</span><span class="min-tag tag-sex-female"><i class="iconfont icon-female"></i> 24</span>--}}
                            {{--<a href="#" class="btn btn-pass">通过</a>--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--申请领取深圳湾徒步下机型后勤职务--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<div>--}}
                        {{--<img src="images/img.png" class="img-head"/>--}}
                    {{--</div>--}}
                    {{--<div class="user-content">--}}
                        {{--<p>--}}
                            {{--<span class="username">lily</span><span class="min-tag tag-sex-female"><i class="iconfont icon-female"></i> 24</span>--}}
                            {{--<a href="#" class="btn btn-pass">通过</a>--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--申请领取深圳湾徒步下机型后勤职务--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</li>--}}

            </ul>
        </div>
    </div>

@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                type: 0,// 0 主页，1 活动提醒消息，2 角色认领消息， 3 评价消息
                userinfo : util.getStore('userinfo'),
                list: [],
                url : '{{url("api/user/systemmsg")}}'
            },
            methods: {
                getlist: function(){
                    var self = this;
                    if(!self.userinfo){
                        alert('请先登录！');
                        window.location.href = "{{ url('lesong/user/login') }}";
                    }
                    switch (self.type){
                        case 0:
                            break;
                        case 1:
                            break;
                        case 2:
                            self.url = '{{ url("api/user/rolemsg") }}';
                            break;
                        case 3:
                            break;
                    }

                    util.get(this,{
                        api: self.url+'?users_id='+self.userinfo.id
                    }).then((res) => {
                        var data = res.data;
                        data.forEach(function(value, index,array){
                            self.list.push(value);
                        });
                    });
                },
                showmesg: function(type){
                    var self = this;
                    self.type = type;
                    self.getlist();
                },
                role_pass: function(id,act_id,users_id,i){
                    //角色申请审核
                    var self = this;
                    util.post(this,{
                        api: '{{ url("api/activities/examine") }}',
                        data: {
                            activities_id: act_id,
                            users_id : users_id,
                            _method: 'PUT'
                        }
                    }).then((res) => {
                        if(res.code == 200){
                            self.list[i].is_pass = 1;
                        }
                        alert(res.msg);
                    });
                }
            }
        });
        app.getlist();
    </script>
@endsection