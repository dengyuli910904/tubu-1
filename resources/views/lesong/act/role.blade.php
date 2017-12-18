@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="main-role">
        <div class="container" v-if="!is_exit_role">
            <h3 class="clearfix">认领角色</h3>
            <ul class="role-list">
                <li v-for="(item,index) in act_role" v-bind:class=" index== choose_index?'active':''" v-if="item.type == 1" v-on:click="chooserole(index)"><a href="#">@{{ item.key }}</a></li>
                {{--<li><a href="#">后勤</a></li>--}}
                {{--<li><a href="#">后卫</a></li>--}}
                {{--<li><a href="#">医务</a></li>--}}
                {{--<li><a href="#">联络员</a></li>--}}
            </ul>
            <button class="button-xl clearfix" v-on:click="dochoose()">认领</button>
        </div>
        <div class="container" v-if="is_exit_role">
            <div class="role-message">
                <h2>你已经认领过角色，不能更改角色。</h2>
            </div>
            <button class="button-xl clearfix" v-on:click="goback()">知道了</button>
        </div>
    </div>

@endsection
@section('script')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                userinfo : util.getStore('userinfo'),
                id : '{{ $data['id'] }}',
                list: [],
                show_menu: false,
                act_role: Config.act_role,
                choose_index: '',
                role_value : '',
                is_exit_role:false,
            },
            methods: {
                chooserole: function(i){
                    var self = this;
                    self.choose_index = i;
                    self.role_value = self.act_role[i].val;
                },
                dochoose: function(){
                    var self = this;
                    if(self.role_value == ''){
                        alert('请选择要申请的角色');
                        return false;
                    }
                    //判断用户是否已经领取过角色，若领取过则
                    util.post(this,{
                        api: '{{url('api/activities/apply')}}',
                        data: {
                            activities_id: self.id,
                            users_id: self.userinfo.id,
                            activities_role_id: self.role_value
                        }
                    }).then( (res) => {
                        if(res.code == 200){
                            alert(res.msg);
                            //返回详情页面
                        window.location.href = "{{ url('lesong/act/detail') }}?id="+self.id;
                        }else if(res.code == 203){
                            self.is_exit_role = true;
                        }
                        else{
                            alert(res.msg);
                        }
                    });
                },
                isexitrole: function(){
                    //判断用户是否已经领取过角色，若领取过则显示已经领取过角色
                    //根据users_id & act_id
                    var self = this;
                    if(!self.userinfo){
                        alert('请先登录')
                        window.location.href = '{{ url('lesong/user/login') }}';
                    }
                },
                goback: function(){
                    window.location.href = "{{ url('lesong/act/detail') }}?id="+this.id;
                }
            }
        });
        app.isexitrole();
    </script>
@endsection