@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="user-home">
        <div class="header">
            <div class="tab">
                <a class="setting" href="{{ url('lesong/user/setting') }}"><i class="iconfont icon-shezhi"></i></a>
                <a class="" href="{{ url('lesong/message/index') }}"><i class="iconfont icon-mail"></i></a>
            </div>
            <div class="userinfo">
                <div class="u-0">
                    <img v-bind:src="userinfo.headimg" class="img-head">
                </div>
                <div class="u-1">
                    <h1>@{{ userinfo.name }}</h1>
                    <p>@{{ userinfo.telphone }}</p>
                </div>
                <div class="u-2">
                    <a href="#"> <i class="iconfont icon-xiangyou1"></i> </a>
                </div>
            </div>
        </div>

        <div class="nav-lists nav-green">
            <ul>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-collect.png') }}"/>
                    <p>我的收藏</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-follow.png') }}"/>
                    <p>我的关注</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-friend.png') }}"/>
                    <p>我的好友</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-point.png') }}"/>
                    <p>我的积分</p>
                </li>
            </ul>
        </div>
        <div class="nav-lists">
            <h3>我的活动</h3>
            <ul>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-create-activite.png') }}"/>
                    <p>创建的</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-manage-activite.png') }}"/>
                    <p>管理的</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-activite.png') }}"/>
                    <p>参加的</p>
                </li>
            </ul>
        </div>
        <div class="nav-lists">
            <h3>俱乐部</h3>
            <ul>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-find-group.png') }}"/>
                    <p>发现</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-create-group.png') }}"/>
                    <p>创建的</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-manage-group.png') }}"/>
                    <p>管理的</p>
                </li>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-group.png') }}"/>
                    <p>参加的</p>
                </li>
            </ul>
        </div>

        <div class="nav-lists">
            <h3>物资管理</h3>
            <ul>
                <li>
                    {{--<i class="iconfont icon-xihuan"></i>--}}
                    <img src="{{ asset('lesong/images/my-product.png') }}"/>
                    <p>物资管理</p>
                </li>
            </ul>
        </div>

        <div class="menu-bar">
            <ul>
                <li class="act">
                    <a href="{{ url('lesong/act/index') }}">
                        <p class="icon">&nbsp;</p>
                        <p>活动</p>
                    </a>
                </li>
                <li class="create"><a href="#">
                        <i class="iconfont icon-addition_fill"></i>
                    </a></li>
                <li class="active me">
                    <a href="#">
                        <p class="icon">&nbsp;</p>
                        <p>我的</p>
                    </a>
                </li>
            </ul>
        </div>

    </div>
@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                id : util.getStore('act_id'),
                userinfo: util.getStore('userinfo')
            },
            methods: {
                getinfo: function () {
                    if(!this.userinfo){
                        window.location.href = "{{url('lesong/user/login')}}";
                    }

                }
            }
        });
        app.getinfo();
    </script>

@endsection