@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('datepicker/js/mobiscroll_002.js')}}" type="text/javascript"></script>
    <script src="{{ asset('datepicker/js/mobiscroll_004.js')}}" type="text/javascript"></script>
    <link href="{{ asset('datepicker/css/mobiscroll_002.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('datepicker/css/mobiscroll.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('datepicker/js/mobiscroll.js')}}" type="text/javascript"></script>
    <script src="{{ asset('datepicker/js/mobiscroll_003.js')}}" type="text/javascript"></script>
    <script src="{{ asset('datepicker/js/mobiscroll_005.js')}}" type="text/javascript"></script>
    <link href="{{ asset('datepicker/css/mobiscroll_003.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="sign-rule">
        <div class="container">
            <div class="row">
                截止签到时间：<input class="row-r-data tr" id="appTime" v-model="deadline"/><label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>
            </div>
            <!--<div class="title-row">-->
            <!--设置迟到捐款规则-->
            <!--</div>-->
            <!--<div class="row">-->
            <!--迟到时间：<label class="row-r-data">10分钟</label><label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>-->
            <!--</div>-->
            <!--<div class="row">-->
            <!--捐款金额：<label class="row-r-data">100元</label><label class="row-r-icon"><i class="iconfont icon-xiangyou1"></i> </label>-->
            <!--</div>-->
            <button class="button-xl clearfix" v-on:click="setsign()">确认</button>
        </div>
        </div>
    </div>

@endsection
@section('script')
    <script>

        $(function () {
            var currYear = (new Date()).getFullYear();
            var opt={};
            opt.date = {preset : 'date'};
            opt.datetime = {preset : 'datetime'};
            opt.time = {preset : 'time'};
            opt.default = {
                theme: 'android-ics light', //皮肤样式
                display: 'modal', //显示方式
                mode: 'scroller', //日期选择模式
                dateFormat: 'yyyy-mm-dd',
                lang: 'zh',
                showNow: true,
                nowText: "现在",
                startYear: currYear - 10, //开始年份
                endYear: currYear + 10 //结束年份
            };

//        $("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
            var optDateTime = $.extend(opt['datetime'], opt['default']);
            var optTime = $.extend(opt['time'], opt['default']);
        $("#appTime").mobiscroll(optDateTime).datetime(optDateTime);
//            $("#appTime").mobiscroll(optTime).time(optTime);
        });

        var app = new Vue({
            el: '#app',
            data:{
                users_id : "{{ $data['id'] }}",
                activities_id: util.getStore('act_id'),
                deadline: '',
                id : "{{ $data['id'] }}",
            },
            methods: {
                getsign:function(){
                    var self = this;
                    var d = new Date();
                    self.deadline = d.getFullYear()+"-"+(parseInt(d.getMonth())+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes();
                },
                setsign: function () {
                    var self = this;
                    util.post(this, {
                        api: '{{url("api/activities/set_sign_rule")}}',
                        data:{
                            users_id: self.users_id,
                            activities_id: self.id,
                            deadline: self.deadline,
                            publish_way:1,
                            publish_num: 0
                        }
                    }).then((res) => {
//                        var data = res.data;
                        alert(res.msg);
                    });
                }
            }
        });
        app.getsign();
    </script>
@endsection