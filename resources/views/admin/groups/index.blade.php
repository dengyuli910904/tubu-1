@extends('admin.layouts.master')

@section('title','新闻管理')
@section('banner-title','新闻管理')
@section('banner-tips','新闻列表')
@section('styles')
    @parent
    <link rel="stylesheet" type="text/css" href="{{asset('admin/fileinput/css/fileinput.css')}}">
    <style type="text/css">
    .table tbody td { max-height: 50px;overflow: hidden; text-overflow:ellipsis; }
    </style>
@endsection

@section('header')
    @parent
@endsection

@section('left-menu')
     @parent
@endsection


@section('content')
            
            
            <div class="row">  
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2><i class="fa fa-table red"></i><span class="break"></span><strong>新闻管理</strong></h2>
                              <div class="panel-actions">
                                <!-- <a href="table.html#" class="btn-setting"><i class="fa fa-rotate-right"></i></a>
                                <a href="table.html#" class="btn-minimize"><i class="fa fa-chevron-up"></i></a> -->
                                <!-- <a href="{{ url('banner/add')}}"><i class="fa fa-times"></i></a> -->
                                
                              </div> 


                        </div>
                        <div class="col-lg-12">
                           @if (count($errors) > 0)
                            <div class="alert alert-danger">
                              <strong>提示!</strong> 您的操作失败<br><br>
                              <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                              </ul>
                            </div>
                          @endif
                        </div>
                        <div class="panel-body">
                            <form action="{{url('admin/news/list')}}" method="POST">
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="text" id="searchtxt" name="searchtxt" class="form-control" placeholder="请输入新闻标题......">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary" onclick="window.location.href='{{ url('admin/news/list')}}'">搜索</button>
                                    <button type="button" class="btn btn-default" onclick="window.location.href='{{ url('admin/news/add')}}'">添加</button>
                                </div>
                              </div>
                            </form>
                            <table class="table table-bordered table-striped table-condensed table-hover">
                                  <thead>
                                      <tr>
                                         <th width="20%">编号</th>
                                         <th width="20%">标题</th>
                                         <th width="20%">简介</th>
                                         <!-- <th width="7%">类型</th> -->
                                         <!-- <th width="10%">标签</th> -->
                                         <th width="10%">状态</th>
                                         <!-- <th width="10%">来源</th> -->
                                         <!-- <th width="8%">是否显示</th> -->
                                         <th width="30%">操作</th>                                          
                                      </tr>
                                  </thead>   
                                  <tbody>
                                    @foreach( $data as $val)
                                    <tr>
                                        <td>{{$val->id}}</td>
                                        <td>{{$val->name}}</td>
                                        <td class="intro">{{$val->intro}}</td>
                                        <!-- <td>1</td> -->
                                        <!-- <td>{{$val->tags}}</td> -->
                                        <td>
                                          @if( $val->is_pass == 0)
                                            待审核
                                          @elseif( $val->is_pass == 2)
                                            审核未通过
                                          @else
                                            {{$val->status == 1?'启用':'禁用'}}
                                          @endif
                                        </td>
                                        <!-- <td>{{$val->resource}}</td> -->
                                        <!-- <td>{{$val->is_hidden === 1?'启用':'禁用'}}</td> -->
                                        <td>
                                            <form action="{{ route('mgroup.update',['id'=>$val->id])}}" method="post" style="display: inline;"> 
                                              <input type="hidden" name="_method" value="PUT">
                                              <!-- <input type="hidden" name="id" value="{{$val->id}}">  -->
                                              <input type="hidden" name="status" value="{{$val->status}}">
                                              <!-- <input type="hidden" name="is_pass" value="{{$val->is_pass}}"> -->
                                              @if($val->is_pass == 1)
                                                <input type="hidden" name="handle_type" value="status">
                                                @if($val->status)
                                                <button type="submit" class="btn btn-default">禁用</button>
                                                @else
                                                <button type="submit" class="btn btn-success">启用</button>
                                                @endif
                                              @elseif($val->is_pass == 0)
                                                <input type="hidden" name="handle_type" value="is_pass">
                                                <button type="submit" class="btn btn-success" value="1" name="is_pass">通过</button>
                                                <button type="submit" class="btn btn-danger" value="2" name="is_pass">不通过</button>
                                              @else
                                                <input type="hidden" name="handle_type" value="is_pass">
                                                <button type="submit" class="btn btn-danger" value="2" name="is_pass">不通过</button>
                                              @endif
                                            </form>
                                            @if(!$val->status)
                                            

                                            <!-- <form action="{{url('admin/news/handle')}}" method="post" style="display: inline;"> 
                                              <input type="hidden" name="id" value="{{$val->id}}"> 
                                              <input type="hidden" name="is_recommend_frontpage" value="{{$val->is_recommend_frontpage}}">
                                               @if($val->is_recommend_frontpage)
                                              <button type="submit" class="btn btn-default">取消首页</button>
                                              @else
                                              <button type="submit" class="btn btn-success">首页推荐</button>
                                              @endif
                                            </form> -->
                                            @endif
                                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('mgroup.edit',['id'=>$val->id ]) }}'">编辑</button>
                                            <button type="button" class="btn btn-danger" onclick="del({{$val->id}})">删除</button>
                                        </td>                                       
                                    </tr>
                                    @endforeach                                                    
                                  </tbody>
                             </table>
                             {{ $data->links() }} 
                             <!-- <ul class="pagination">
                                <li><a href="table.html#">上一页</a></li>
                                <li class="active">
                                  <a href="table.html#">1</a>
                                </li>
                                <li><a href="table.html#">2</a></li>
                                <li><a href="table.html#">3</a></li>
                                <li><a href="table.html#">4</a></li>
                                <li><a href="table.html#">5</a></li>
                                <li><a href="table.html#">下一页</a></li>
                              </ul>      -->
                        </div>
                    </div>
                </div><!--/col-->
            </div>    
                    
        </div>
      <script type="text/javascript">
       function del(id)
        {
            $.ajax({
                url: "/admin/mgroup/" + id,
                type:'post',
                data:{
                    _method: 'delete'
                },
                dataType: 'json',
                success: function(data){
                    alert(data.msg);
                    window.location.reload();
                }
            });
        }
          // $.ajax({
          //   url: "{{ url('banner/handle')}}",
          //   type:'Post',
          //   data:{
          //     id:1,
          //     isfalse:0
          //   },
          //   success: function(data){
          //       alert('dfdfd');
          //   }
          // });
      </script>
@endsection
