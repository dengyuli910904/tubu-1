
@extends('admin.layouts.master');
@section('title','新闻管理')
@section('banner-title','新闻管理')
@section('banner-tips','新闻编辑')

@section('header')
    @parent
@endsection

@section('left-menu')
     @parent
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2><i class="fa fa-indent red"></i><strong>添加新闻</strong></h2>
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
    <form action="{{ url('news/doedit')}}" method="post" enctype="multipart/form-data" class="form-horizontal ">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-3 control-label" for="text-input">标题</label>
                <div class="col-md-9">
                    <input type="text" id="title" name="title" class="form-control" value="{{$data->title}}">
                    <!-- <span class="help-block">This is a help text</span> -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="textarea-input">新闻简介</label>
                <div class="col-md-9">
                    <textarea id="intro" name="intro" rows="9" class="form-control">{{$data->intro}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="textarea-input">新闻类型</label>
                <div class="col-md-9">
                    <input type="text" id="type" name="type" class="form-control" value="1">
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">封面图片</label>
                <div class="col-md-9">
                    
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">新闻标签</label>
                <div class="col-md-9">
                    <input type="text" id="newstag" name="newstag" class="form-control" value="{{$data->newstag}}">
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">发布时间</label>
                <div class="col-md-9">
                    <input type="text" id="publishtime" name="publishtime" class="form-control" value="{{$data->publishtime}}">
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">新闻来源</label>
                <div class="col-md-9">
                    <input type="text" id="resource" name="resource" class="form-control"  value="{{$data->resource}}">
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">来源链接</label>
                <div class="col-md-9">
                    <input type="text" id="resourceurl" name="resourceurl" class="form-control" value="{{$data->resourceurl}}">
                </div>
            </div>
            <div class="form-group">

                <label class="col-md-3 control-label" for="textarea-input">关键词</label>
                <div class="col-md-9">
                    <input type="text" id="keyword" name="keyword" class="form-control" value="{{$data->keyword}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="textarea-input">新闻内容</label>
                <div class="col-md-9">
                     <script id="ueditor"></script>
                </div>
            </div>
            
            
            
            <div class="form-group">
                <label class="col-md-3 control-label">责任编辑</label>
                <div class="col-md-9">
                    <input type="text" id="editor" name="editor" class="form-control" value="{{$data->editor}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">点击量</label>
                <div class="col-md-9">
                    <input type="number" id="clicknum" name="clicknum" class="form-control" value="{{$data->clicknum}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">阅读量</label>
                <div class="col-md-9">
                    <input type="number" id="readnum" name="readnum" class="form-control" value="{{$data->readnum}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">排序</label>
                <div class="col-md-9">
                    <input type="number" id="ordernum" name="ordernum" class="form-control" value="{{$data->ordernum}}">
                </div>
            </div>

            <input type="hidden" id="cover" value="" name="cover">
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> 提交</button>
            <!-- <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> 重置</button> -->
        </div> 
    </form> 
    <script>
        var ue=UE.getEditor("ueditor");
        ue.ready(function(){
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行
            ue.execCommand('serverparam','_token','{{ csrf_token() }}');
            editor.setContent("{{$data->content}}");   
        });
    </script>
</div>
@endsection
