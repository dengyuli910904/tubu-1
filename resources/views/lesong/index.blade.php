<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Live Song</title>
    <META HTTP-EQUIV="Expires" CONTENT="0">

    <meta name="author" content="www.livesong.cn">
    <meta name="distribution" content="Global">
    <meta name="robots" content="all">
    <link href="{{ asset('lesong/css/common.css?12222')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('lesong/css/lesong.css?rand=<script type="text/javascript">Math.random()</script>')}}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('lesong/js/jquery-1.7.2.min.js')}}"></script>
    <!--[if IE]>
    <script src="js/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="main" id="app">
    <div class="search-box">
        <a href="#" class="site"><i class="icon iconfont icon-coordinates"></i></a>
        <input type="text" placeholder="搜索活动" class="search-input" name="search-txt" v-model="search_txt">
        <a href="{{ url('lesong/message/index') }}" class="mail">
            <i class="iconfont icon-mail"></i>
        </a>
    </div>
    <div class="nav">
        <ul>
            <li v-bind:class="index == 1?'active':''" v-on:click="search(1,'',0)"><a href="#">热门</a></li>
            <li v-bind:class="index == 3?'active':''"  id="choose-tag" v-on:click="changetag('tag')" type="selected"><a href="#">标签<i class="iconfont icon-xiangxia2"></i></a> </li>
            <li v-bind:class="index == 2?'active':''" v-on:click="search(2,'',0)"><a href="#">最新</a> </li>
            <li v-bind:class="index == 4?'active':''" id="choose-pay" v-on:click="changetag('pay')"  type="selected"><a href="#">付费类型<i class="iconfont icon-xiangxia2"></i></a> </li>
        </ul>
        <div class="panel" v-if="show_panel">
            <div class="choose-tag" v-if="show_panel && show_tag">
                <label v-for="(t,index) in act_type" v-on:click="search(3,t,index)" v-bind:data-id="index" v-bind:class="index == show_tag_index?'active':''">@{{  t }}</label>
                {{--<label>跑步</label>--}}
                {{--<label>旅行</label>--}}
                {{--<label>骑行</label><br/>--}}
                {{--<label>登山</label>--}}
                {{--<label>其他</label>--}}
            </div>
            <div class="choose-pay" v-if="show_panel && show_pay">
                <label v-for="(p,i) in act_pay" v-on:click="search(4,i,i)" v-bind:data-id="index" v-bind:class="i == show_pay_index?'active':''">@{{  p }}</label>
                {{--<label>AA</label>--}}
                {{--<label>全包</label>--}}
                {{--<label>定制</label>--}}
            </div>
        </div>
    </div>
    <div class="act-list">
        <ul>
            <li v-for="item in list">
                {{--<a href="{{ url('lesong/act/detail?id=item.id') }}">--}}
                <div style="max-height: 230px; overflow: hidden;">
                    <img v-bind:src="item.cover" class="img-responsive" v-on:click="link_to('lesong/act/detail',item.id)"/>
                </div>

                {{--</a>--}}

                <div class="act-content">
                    <h1>@{{ item.title }}<label class="t-price">￥@{{ item.cost}}</label></h1>
                    <p>
                        <label class="act-tag t-ready">@{{ item.statusText }}</label>
                        <label class="act-tag t-cate">@{{ item.keywords }}</label>
                        <label class="act-tag t-pay">@{{ act_pay[item.pay_type] }}</label>
                    </p>
                    <p>| 报名截止时间：<label>@{{ item.endtime }} </label></p>
                    <p>| 活动开始时间：<label>@{{ item.enrol_endtime }}</label> <label class="t-num">
                            <i class="iconfont icon-people_fill"></i> @{{ item.limit_count }}人</label></p>
                </div>
            </li>

        </ul>
    </div>
    <div class="menu-bar">
        <ul>
            <li class="active act">
                <a href="#">
                    <p class="icon">&nbsp;</p>
                    <p>活动</p>
                </a>
            </li>
            <li class="create"><a href="#">
                    <i class="iconfont icon-addition_fill"></i>
                </a></li>
            <li class="me">
                <a href="{{ url('lesong/user/index') }}">
                    <p class="icon">&nbsp;</p>
                    <p>我的</p>
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="{{ asset('lesong/js/public.js') }}"></script>
<script src="{{ asset('lesong/js/config.js') }}"></script>
<script src="{{ asset('lesong/js/util.js') }}"></script>
<script src="{{ asset('lesong/js/vue.min.js') }}"></script>
<script>
    var app = new Vue({
        el: '#app',
        data:{
            index: 0,
            search_key: '',
            search_value: '',
            search_txt: '',
            pageindex: 0,
            pagesize: 100,
            users_id: '',
            list: [],
            act_type: Config.act_type,
            act_pay: Config.act_pay,
            show_panel: false,
            show_tag: false,
            show_pay: false,
            show_pay_index: -1,
            show_tag_index:-1,
        },
        methods: {
            changetag: function(val){
                var self = this;
                if(val == "tag"){
                    self.index = 1;
                    self.show_tag = !self.show_tag;
                    self.show_pay = false;
                }else{
                    self.index = 3;
                    self.show_pay = !self.show_pay;
                    self.show_tag = false;
                }
                if(self.show_pay || self.show_tag){
                    self.show_panel = true;
                }else{
                    self.show_panel = false;
                }
            },
            search: function(key,value,index){
                var self = this;
                self.search_key = key;
                self.pageindex = 0;
                switch (key){
                    case 1:
                        self.index = 2;
                        break;
                        //热门
                    case 2:
                        self.index = 2;
                        //最新
                        break;
                    case 3:
                        //活动类型
//                        self.index = 0;
                        self.show_tag_index = index;
                        self.show_pay_index = 0;
                        self.search_value = value;
                        break;
                    case 4:
//                        self.index = 2;
                        self.show_pay_index = index;
                        self.show_tag_index = 0;
                        self.search_value = value;
                        //付费类型
                        break;
                }
                self.show_panel = false;
                self.show_tag = false;
                self.show_pay = false;
                self.getlist();
            },
            getlist: function(){
                var self = this;
                util.get(this,{
                    api: '{{url("api/activities/act_list")}}?search_key='+self.search_key+"&search_value="+self.search_value+"&search_txt="+self.search_txt+"&pageindex="+self.pageindex+"&pagesize="+self.pagesize
                }).then((res) => {
                    var data = res.data;
                    if(self.pageindex ==0 ){
                        self.list = [];
                    }
                    data.forEach(function(value, index,array){
                        value.statusText = Config.act_status[value.status];
                        self.list.push(value);
                    });
                });
            },
            link_to: function(url,id){
                util.setStore('act_id',id);
                window.location.href = Config.WEB_URL+'/'+url+"?id="+id;
            }
        }
    });
    app.getlist();
</script>
</body>
</html>