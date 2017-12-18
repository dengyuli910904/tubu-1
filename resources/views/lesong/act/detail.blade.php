@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?dfgdfgdf')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('lesong/css/GalMenu.css') }}" rel="stylesheet" type="text/css"/>
    {{--<script src="{{ asset('lesong/js/jquery-2.1.3.min.js') }}" type="text/javascript"></script>--}}
    <script src="{{ asset('lesong/js/GalMenu.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#menu').GalMenu({
                'menu': 'GalDropDown'
            })
        });
    </script>
    @endsection
@section('content')
    <div class="act-body">
        <div style="max-height: 280px; overflow: hidden;">
            <img v-bind:src="info.activityinfo.cover" class="img-responsive">
        </div>
        <div class="row">
            <div class="act-content container">
                <div style="clear: both;">
                    <div style="width: 70%;" class="fl"><h1> @{{ info.activityinfo.title }}</h1></div>
                    <div class="fl">
                        <a href="javascript:void(0);" class="sign-in" v-on:click="sign()" v-if="info.set_sign_rule"><i class="iconfont icon-emoji"></i> 发起签到</a>
                        <a href="javascript:void(0);" class="sign-in" v-on:click="sign()" v-if="!info.set_sign_rule && info.is_check_in == 1"><i class="iconfont icon-emoji"></i> 签到</a>
                        <a href="javascript:void(0);" class="sign-in" v-if="!info.set_sign_rule && info.is_check_in == 2"><i class="iconfont icon-emoji"></i> 已签到</a>
                    </div>
                </div>

                <div class="act-star" style="clear: both;">
                    <i class="iconfont icon-biaoxingfill"></i>
                    <i class="iconfont icon-biaoxing"></i>
                    <i class="iconfont icon-biaoxing"></i>
                    <i class="iconfont icon-biaoxing"></i>
                    <i class="iconfont icon-biaoxing"></i>
                </div>
                <div>
                    <label class="act-tag t-ready">@{{ info.activityinfo.status_text }}</label>
                    <label class="act-tag t-cate">@{{ info.activityinfo.keywords }}</label>
                    <label class="act-tag t-pay">免费</label>
                    <label>￥ @{{ info.activityinfo.cost }}</label>
                    <label class="collect"> <i class="iconfont icon-xihuan"></i> 收藏：@{{ info.activityinfo.collect_count }} </label>
                </div>
                <!--<hr>-->
                <div class="act-date">
                    <ul>
                        <li>
                            <h2>报名截止时间：</h2>
                            <p>@{{ info.activityinfo.enrol_endtime }}</p>
                        </li>
                        <li>
                            <h2>活动开始时间：</h2>
                            <p>@{{ info.activityinfo.starttime }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <h2>活动内容</h2>
                <div class="long-text">
                    <p class="text-content" v-html="info.activityinfo.content">
                       @{{ info.activityinfo.content }}
                    </p>
                    <p class="long-hide"  v-on:click="showorhide(event)"> <i class="iconfont icon-more"></i></p>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="container">
                <h2>费用内容</h2>
                <div class="long-text">
                    <p class="text-content">
                        @{{ info.activityinfo.cost_intro }}
                    </p>
                    <p class="long-hide show-less"  v-on:click="showorhide(event)"> <i class="iconfont icon-more"></i></p>
                </div>

            </div>
        </div>
        <div class="row user-list">
            <div class="container">
                <h2>所属圈子：<span>@{{ info.groupsinfo.name }}</span><span>12</span></h2>
                <div class="act-leader"><img v-bind:src="info.leaderinfo.headimg" class="img-head">  <a href="#">@{{ info.leaderinfo.name }}</a><a href="#">@{{ info.leaderinfo.telphone }}</a></div>
                <ul class="act-user-list">
                    <li v-for="(m,index) in info.members" v-if="index < 3"><a href="#"><img v-bind:src="m.headimg" class="img-head"></a></li>
                    {{--<li><a href="#"><img src="images/user.png" class="img-head"></a></li>--}}
                    {{--<li><a href="#"><img src="images/user.png" class="img-head"></a></li>--}}
                    {{--<li><a href="#"><img src="images/user.png" class="img-head"></a></li>--}}
                    <li><a href="#"><i class="icon iconfont icon-addition"></i></a> </li>
                    <li><a href="{{url('lesong/act/users')}}">@{{ info.members.length+1}}/@{{ info.activityinfo.limit_count }}人</a> </li>
                    <li class="icon-more-list tr"><a  href="javascript:void(0);" v-on:click="getlist"> <i class="iconfont icon-xiangyou1"></i> </a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="menu-bar clearfix">
        <div class="options fl">
            <ul>
                <li class="share">
                    <a href="#" title="分享">
                        <i class="icon iconfont icon-forward"></i>
                    </a>
                </li>
                <li v-bind:class="{'collect':1, 'active':info.is_collect }" v-on:click="collect()"><a href="javascript:void(0);" >
                        <i class="iconfont icon-xihuan"></i>
                    </a></li>
                <li class="message">
                    <a href="#">
                        <i class="icon iconfont icon-xinxi"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="fl action-btn">
            {{--1 立即报名--}}
            {{--2 已报名--}}
            {{--3 立即支付--}}
            {{--4 结束报名--}}
            {{--5 活动结束--}}
            <input v-if="btn_status == 0" class="btn-manager" v-on:click="dosubmit()" type="button" value="点击正式发布">
            <input v-if="btn_status == 1" class="btn-manager" v-on:click="dosubmit()" type="button" value="立即报名">{{-- rgb(94,98,107)--}}
            <input v-if="btn_status == 2" class="btn-label" type="button" value="已参加">{{-- rgb(179，179，179)--}}
            <input v-if="btn_status == 3" class="btn-pay" v-on:click="dosubmit()" type="button" value="立即支付"> {{--主题绿色--}}
            <input v-if="btn_status == 4" class="btn-manager" v-on:click="dosubmit()" type="button" value="点击结束报名">
            <input v-if="btn_status == 5" class="btn-manager" v-on:click="dosubmit()" type="button" value="点击结束活动">
            <input v-if="btn_status == 6" class="btn-label"  type="button" value="已取消">
            <input v-if="btn_status == 7" class="btn-label"  type="button" value="已结束">{{-- rgb(179，179，179)--}}
            <input v-if="btn_status == 8" class="btn-label"  type="button" value="报名已截止">{{-- rgb(179，179，179)--}}
        </div>
    </div>



    @endsection
@section('script')
    <!--浮动菜单-->
    {{--菜单位置参照--}}
    {{--<div style="border-radius: 250px; width: 250px; height: 250px; border: 1px solid red; margin-left: -120px; position: fixed; right: -60px; bottom: 15px;">--}}
    {{--</div>--}}
    <div class="menu" id="menu">
        <a hre="#" class="menu-toggle-button" >
            {{--v-on:click="showmenu()"--}}
            <img src="{{ asset('lesong/images/menu-main.png')}}" width="60px"/>
            {{--<i class="iconfont icon-addition_fill"></i>--}}
        </a>
    </div>
    <div class="float-menu-body">
        <div class="GalMenu GalDropDown">
            <div class="circle" id="gal">
                <div class="ring">
                    <a href="javascript:void(0);" title="总结" class="menuItem">
                        <img src="{{ asset('lesong/images/menu-count.png') }}" width="40px" />
                        <p>总结</p>
                    </a>
                    <a href="javascript:void(0);" target="_blank" title="咨询" class="menuItem">
                        <img src="{{ asset('lesong/images/menu-summedup.png') }}" width="40px"/>
                        <p>咨询</p>
                    </a>
                    <a href="javascript:void(0);" target="_blank" title="评价" class="menuItem">
                        <img src="{{ asset('lesong/images/menu-comment.png') }}" width="40px"/>
                        <p>评价</p>
                    </a>
                    <a href="javascript:void(0);" target="_blank" title="公示" class="menuItem">
                        <img src="{{ asset('lesong/images/menu-tips.png') }}" width="40px"/>
                        <p>公示</p>
                    </a>
                    <a href="{{url('lesong/act/role')}}?id={{$data['id']}}" target="_blank" title="角色" class="menuItem">
                        <img src="{{ asset('lesong/images/menu-role.png') }}" width="40px"/>
                        <p>角色</p>
                    </a>
                    {{--<a href="javascript:void(0);" target="_blank" title="" class="menuItem">后宫</a>--}}
                    {{--<a href="javascript:void(0);" target="_blank" title="" class="menuItem">杂货</a>--}}
                    {{--<a href="javascript:void(0);" target="_blank" title="" class="menuItem">洗脑</a>--}}
                </div>
            </div>
        </div>
    </div>
    {{--<div class="float-menu-body" v-if="show_menu">--}}
    {{--<div class="menu-list">--}}
    {{--<ul class="menu-items">--}}

    {{--<li class="menu-item" style=" right: 193px; bottom: 55px;">--}}
    {{--<a href="#" class="menu-summedup">--}}
    {{--<img src="{{ asset('lesong/images/menu-count.png') }}"/>--}}
    {{--<i class="iconfont icon-community"></i>--}}
    {{--</a>--}}
    {{--<p>总结</p>--}}
    {{--</li>--}}
    {{--<li class="menu-item" style=" right: 202px; bottom: 125px;">--}}
    {{--<a href="#">--}}
    {{--<img src="{{ asset('lesong/images/menu-summedup.png') }}"/>--}}
    {{--</a>--}}
    {{--<p>咨询</p>--}}
    {{--</li>--}}
    {{--<li class="menu-item" style=" right: 173px; bottom: 194px;">--}}
    {{--<a href="#" class="menu-comment">--}}
    {{--<img src="{{ asset('lesong/images/menu-comment.png') }}"/>--}}
    {{--<i class="iconfont icon-community"></i>--}}
    {{--</a>--}}
    {{--<p>评价</p>--}}
    {{--</li>--}}
    {{--<li class="menu-item" style=" right: 114px; bottom: 240px;">--}}
    {{--<a href="#" class="menu-tips">--}}
    {{--<img src="{{ asset('lesong/images/menu-tips.png') }}"/>--}}
    {{--<i class="iconfont icon-community"></i>--}}
    {{--</a>--}}
    {{--<p>公示</p>--}}
    {{--</li>--}}
    {{--<li class="menu-item" style=" right: 47px; bottom: 252px;">--}}
    {{--<a href="{{url('lesong/act/role')}}?id={{$data['id']}}" class="menu-role">--}}
    {{--<img src="{{ asset('lesong/images/menu-role.png') }}"/>--}}
    {{--<i class="iconfont icon-community"></i>--}}
    {{--</a>--}}
    {{--<p>角色</p>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    <script type="text/javascript">
        $('.float-menu-body').attr('style','display:none;');
//        window.onload = function(){
            var items = document.querySelectorAll('.menuItem');
            var l = 18;
            //items.length
            for (var i = 0,l = 8; i < l; i++) {
                if(i<=items.length){
                    items[i].style.right = (50 - 35 * Math.cos( - 0.5 * Math.PI - 2 * (1 / l) * i * Math.PI)).toFixed(4) + "%";
                    items[i].style.bottom = (50 + 35 * Math.sin( - 0.5 * Math.PI - 2 * (1 / l) * i * Math.PI)).toFixed(4) + "%"
                }
            }
//        }

    </script>
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                btn_status: 1,
                users_id : '',
                userinfo: util.getStore('userinfo'),
                id : "{{ $data['id'] }}",//util.getStore('act_id'),
                info:'',
//                show_menu: false,
                submit_text: "立即报名",
//                user_act_role: 1,// 1 参与用户；2 管理用户
            },
            methods: {
                getlist:function(){
                    window.location.href = "{{url('lesong/act/users')}}"+'?id='+this.id;
                },
                getinfo: function(){
                    var self = this;
                    if(self.userinfo){
                        self.users_id = self.userinfo.id;
                    }
                    util.get(this,{
                        api: '{{url("api/activities/info")}}?id='+self.id+"&users_id="+self.users_id
                    }).then((res) => {
                        if(res.code == "200"){
                            var data = res.data;
                            self.info = data;
                            self.setbtnstatus();
                        }
                    });
                },
                setbtnstatus: function(){
                    {{--1 立即报名--}}
                    {{--2 已报名--}}
                    {{--3 立即支付--}}
                    {{--4 结束报名--}}
                    {{--5 活动结束--}}

                    var self = this;
                    //若用户已经报名
                    if(self.info.is_sign_in){
                        //用户的角色
                        //1正式发布；2结束报名状态；3取消活动；4活动结束
                        if(self.info.user_act_role == 2 || self.info.user_act_role == 1){
                            //管理者角色
                            switch(self.info.activityinfo.status){
                                case 0:
                                    self.btn_status = 0;
                                    break;
                                case 1:
                                    self.btn_status = 4;
                                    break;
                                case 2:
                                    self.btn_status = 5;
                                    break;
                                case 3:
                                    self.btn_status = 6;
                                    //活动已取消
                                    break;
                                case 4:
                                    //活动一结束
                                    self.btn_status = 7;
                                    break;
                            }
                        }else{
                            //参与者角色
                            switch(self.info.activityinfo.status){
                                case 0:
                                    self.btn_status = 0;
                                    //未发布的项目，普通用户无法看到
                                    break;
                                case 1:
                                    //正式发布的项目
                                    if(self.is_pay){
                                        //已经支付
                                        self.btn_status = 2;
                                    }
                                    else{
                                        //未支付
                                        self.btn_status = 3;
                                    }
                                    break;
                                case 2:
                                    //报名已经截止
                                    self.btn_status = 8;
                                    break;
                                case 3:
                                    self.btn_status = 6;
                                    //活动已取消
                                    break;
                                case 4:
                                    //活动一结束
                                    self.btn_status = 7;
                                    break;
                            }
                        }
                    }
                    else{
                        //用户没有报名
//                        self.btn_status = 1;
                    }
                },
                showorhide: function(event){
                    let ele = event.target;
                    if($(ele).hasClass('icon-less')){
                        $(ele).parents('.long-text').find('.text-content').css('height','65');
                    }else{
                        // alert('ddd');
                        $(ele).parents('.long-text').find('.text-content').css('height','auto');
                    }
                    $(ele).toggleClass('icon-less');
                    $(ele).toggleClass('icon-more');
                },
                showmenu: function(){
                    var self = this;
                    self.show_menu = !self.show_menu;
                    if(self.show_menu){
                        $('body').attr('style','height:'+$(window).height()+'px;overflow:hidden;');
                    }
                    else{
                        $('body').attr('style','height:auto;');
                    }
                },
                dosubmit: function(){
                    var self = this;
                    if( !self.userinfo ){
                        alert('请先登录');
                    }

                    switch (self.btn_status){
                        case 1:
                            //去报名
                            util.post(this,{
                                api: '{{url("api/amembers/takein")}}',
                                data:{
                                    users_id: self.userinfo.id,
                                    activities_id: self.id,
                                    comment: '参与活动'
                                }
                            }).then((res) => {
                                if(res.code == 200){
                                    self.info.is_check_in = 1;
                                    self.btn_status = 2;
                                    if(res.data.need_pay){
                                        alert('您已经报名，请在App进行信息完善！');
                                        window.location.href = "{{ url('lesong/download') }}";
                                    }
                                }else{
                                    alert(res.msg);
                                }
                            });
                            break;
                        case 3:
                            //去支付
                            {{--if(!self.is_sign_in){--}}
{{--//                                发送参与活动申请--}}
                                {{--util.post(this,{--}}
                                    {{--api: '{{url("api/amembers/takein")}}',--}}
                                    {{--data:{--}}
                                        {{--users_id: self.userinfo.id,--}}
                                        {{--activities_id: self.id,--}}
                                        {{--comment: '参与活动'--}}
                                    {{--}--}}
                                {{--}).then((res) => {--}}
                                    {{--if(res.code == 200){--}}
                                        {{--self.info.is_check_in = 1;--}}
                                        {{--self.btn_status = 2;--}}
                                        {{--if(res.data.need_pay){--}}
                                            alert('您已经报名，请在App进行信息完善！');
                                            window.location.href = "{{ url('lesong/download') }}";
//                                        }
//                                    }else{
//                                        alert(res.msg);
//                                    }
//                                });
//                            }
                            //直接调取微信支付
                            break;
                        case 2:
                        case 7:
                            //无操作
                            break;
                        case 4:
                            util.post(this,{
                                api : "{{ url('api/activities/setstatus') }}",
                                data:{
                                    id: self.id,
                                    step: 2, //1正式发布；2结束报名状态；3取消活动；4活动结束
                                    users_id: self.userinfo.id,
                                    _method: 'PUT'
                                }
                            }).then((res) => {
                                self.btn_status = 5;
                            });
                            break;
                        case 5:
                            util.post(this,{
                                api : "{{ url('api/activities/setstatus') }}",
                                data:{
                                    id: self.id,
                                    step: 4, //1正式发布；2结束报名状态；3取消活动；4活动结束
                                    users_id: self.userinfo.id,
                                    _method: 'PUT'
                                }
                            }).then((res) => {
                                self.btn_status = 4;
                            });
                            break;
                        case 0:
                            //正式发布
                            util.post(this,{
                                api : "{{ url('api/activities/setstatus') }}",
                                data:{
                                    id: self.id,
                                    step: 1, //1正式发布；2结束报名状态；3取消活动；4活动结束
                                    users_id: self.userinfo.id,
                                    _method: 'PUT'
                                }
                            }).then((res) => {
                                self.btn_status = 4;
                            });
                            break;
                    }
                },
                sign:function(){
                    //判断用户，若是领队则进入签到规则设置，若为成员则直接执行签到，若非活动报名成员则提醒先参与活动
                    var self = this;
                    if( !self.userinfo ){
                        alert('请先登录');
                        window.location.href="{{ url('lesong/user/login') }}"
                    }
                    switch(self.info.user_act_role){
                        case 0:
                            alert('您还未参与活动');
                            break;
                        case 1:
                        case 2:
//                            alert('设置签到规则');
                            window.location.href = "{{ url('lesong/act/sign') }}?id="+self.id;
                            break;
                        case 3:
                            util.post(this,{
                                api : "{{ url('api/activities/sign') }}",
                                data : {
                                    activities_id : self.id,
                                    users_id : self.userinfo.id
                                }
                            }).then((res) =>{
                                if(res.code == "200"){
                                    alert('签到成功！');
                                    self.info.is_check_in = 2;
                                }else{
                                    alert(res.msg);
                                }
                            });
                            break;
                    }
                },
                collect: function(){

                    var self = this;
                    if( !self.userinfo ){
                        alert('请先登录');
                        window.location.href="{{ url('lesong/user/login') }}"
                    }
                    var _method = "POST";
                    if(self.info.is_collect){
                        _method = "DELETE";
                    }
                    util.post(this,{
                        api : "{{ url('api/activities/collect') }}",
                        data : {
                            activities_id : self.id,
                            users_id : self.userinfo.id,
                            _method: _method
                        }
                    }).then((res) =>{
                        if(res.code == 200){
                            self.info.is_collect = !self.info.is_collect;
                        }
                        alert(res.msg);
                    });
                }
            }
        });
        app.getinfo();
    </script>
    @endsection