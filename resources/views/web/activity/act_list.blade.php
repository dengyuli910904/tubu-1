@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('fileinput/css/fileinput.css') }}">
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row">  
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2><i class="fa fa-table red"></i><span class="break"></span><strong>活动管理</strong></h2>
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
                                  <!-- <input type="text" id="searchtxt" name="searchtxt" class="form-control" placeholder="请输入新闻标题......"> -->
                                </div>
                                <div class="col-md-3">
                                    <!-- <button type="submit" class="btn btn-primary" onclick="window.location.href='{{ url('adminh/news/list')}}'">搜索</button> -->
                                    <button type="button" class="btn btn-default" onclick="window.location.href='{{ route('activity.create')}}'">添加</button>
                                </div>
                              </div>
                            </form>
                            <table class="table table-bordered table-striped table-condensed table-hover">
                                  <thead>
                                      <tr>
                                         <th width="20%">标题</th>
                                         <th width="20%">费用说明</th>
                                         <th width="20%">联系人</th>
                                         <th width="10%">关键词</th>
                                         <th width="30%">操作</th>                                          
                                      </tr>
                                  </thead>   
                                  <tbody>
                                    @foreach( $data as $val)
                                    <tr>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->cost_intro}}</td>
                                        <td class="intro">{{$val->contacts}}</td>
                                        <td>{{$val->keyword}}</td>
                                        <td>
                                            <form action="" method="post" style="display: inline;"> 
                                              <input type="hidden" name="id" value="{{$val->id}}"> 
                                              <input type="hidden" name="status" value="{{$val->status}}">
                                              @if(!$val->status)
                                              <button type="submit" class="btn btn-default">禁用</button>
                                              @else
                                              <button type="submit" class="btn btn-success">启用</button>
                                              @endif
                                            </form>
                                            
                                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('activity.edit',['id'=>$val->id])}}'">编辑</button>
                                            <button type="button" class="btn btn-danger" onclick="">删除</button>
                                        </td>                                       
                                    </tr>
                                    @endforeach                                                    
                                  </tbody>
                             </table>
                             {{ $data->links() }} 
                        </div>
                    </div>
                </div><!--/col-->
            </div>    
                    
        </div>
@endsection
@section('scripts')
    
@endsection