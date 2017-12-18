@extends('lesong.layouts.app')
@section('style')
    <link href="{{ asset('lesong/css/float-menu.css?12222')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="act-user">
        <div class="search-box">
            <input type="text" placeholder="搜索成员" class="search-input" name="search-txt">
        </div>
        <div class="user-items">
            <ul>
                <li v-for="item in list">
                    <a href="javascript:void(0);">
                        <div>
                            <img v-bind:src="item.headimg" class="img-head"/>
                        </div>
                        <div class="user-content">
                            <p style="height: 30px;"> <span class="username">@{{ item.name }}</span><span class="telphone">@{{ item.telphone }}</span></p>
                            <p>
                                <span v-if="item.sex == 0" class="min-tag tag-sex-female">
                                    <i class="iconfont icon-female"></i>
                                    @{{ item.age }}</span>
                                <span v-if="item.sex == 1" class="min-tag tag-sex-male">
                                    <i class="iconfont icon-male"></i>
                                    @{{ item.age }}</span>

                                <span class="min-tag tag-identity">@{{ item.role_text }}</span>
                            </p>
                        </div>
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
                users_id : '',
                activities_id: util.getStore('act_id'),
                searchtxt: '',
                id : util.getStore('act_id'),
                list: [],
                show_menu: false,
                act_role: Config.act_role,
            },
            methods: {
                getlist: function(){
                    var self = this;
                    util.get(this,{
                        api: '{{url("api/amembers/members")}}?activities_id='+self.activities_id+"&searchtxt="+self.searchtxt+"&users_id="+self.users_id
                    }).then((res) => {
                        var data = res.data;
                        data.forEach(function(value, index,array){
                           self.act_role.forEach(function(val,i,a){
                                if(value.role == val.val){
                                    value.role_text = val.key;
                                    return;
                                }
                            });
                            self.list.push(value);
                        });

                    });
                },

            }
        });
        app.getlist();
    </script>
@endsection