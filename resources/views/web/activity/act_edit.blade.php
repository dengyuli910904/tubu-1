@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('fileinput/css/fileinput.css') }}">
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><i class="fa fa-indent red"></i><strong>添加活动</strong></h2>
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
        <form action="{{ route('activity.update',['id'=>$model->id])}}" method="post" enctype="multipart/form-data" class="form-horizontal ">
            <input type="hidden" name="_method" value="PUT">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">选择圈子</label>
                    <div class="col-md-9">
                        <select class="form-control" name="groups_id">
                        @foreach($groups as $g)
                            @if($g->id == $model->groups_id)
                                <option value="{{$g->id}}" selected="true">{{$g->name}}</option>
                            @else
                                <option value="{{$g->id}}">{{$g->name}}</option>
                            @endif
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动封面</label>
                    <div class="col-md-9">
                        <input type="file" name="upfile" id="upfile" multiple class="file-loading" />
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动标题</label>
                    <div class="col-md-9">
                        <input type="text" id="title" name="title" class="form-control" placeholder="活动标题" value="{{ $model->title}}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动内容</label>
                    <div class="col-md-9">
                        <script id="ueditor"></script>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动费用</label>
                    <div class="col-md-9">
                        <input type="number" id="cost" name="cost" class="form-control" placeholder="活动费用" value="{{ $model->cost }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动费用说明</label>
                    <div class="col-md-9">
                        <textarea class="form-control" style="resize:none" name="cost_intro" rows="5">{{$model->cost_intro}}</textarea>
                        <!-- <input type="text" id="bannertitle" name="bannertitle" class="form-control" placeholder="活动费用说明"> -->
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动时间</label>
                    <div class="col-md-9">
                        <input type="text" id="starttime" name="starttime" class="form-control" placeholder="活动时间" value="{{ $model->starttime }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动报名时间</label>
                    <div class="col-md-9">
                        <input type="text" id="enrol_starttime" name="enrol_starttime" class="form-control" placeholder="活动报名时间" value="{{ $model->enrol_starttime }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动联系人</label>
                    <div class="col-md-9">
                        <input type="text" id="contacts" name="contacts" class="form-control" placeholder="活动联系人" value="{{ $model->contacts }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动联系人电话</label>
                    <div class="col-md-9">
                        <input type="text" id="contacts_tel" name="contacts_tel" class="form-control" placeholder="活动联系人电话" value="{{ $model->contacts_tel }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动人数上限</label>
                    <div class="col-md-9">
                        <input type="text" id="limit_count" name="limit_count" class="form-control" placeholder="活动人数上限" value="{{ $model->limit_count }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">关键词</label>
                    <div class="col-md-9">
                        <input type="text" id="keywords" name="keywords" class="form-control" placeholder="关键词" value="{{ $model->keywords }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="text-input">活动备注</label>
                    <div class="col-md-9">
                        <input type="text" id="comment" name="comment" class="form-control" placeholder="活动备注" value="{{ $model->comment }}">
                        <!-- <span class="help-block">This is a help text</span> -->
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> 提交</button>
                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> 重置</button>
            </div> 

            <input type="hidden" name="cover" id="cover" value="{{ $model->cover }}">
            <input type="hidden" id="content" value="{{$model->content}}">
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('fileinput/js/fileinput.js') }}"></script>
    <script type="text/javascript">

        //文本编辑器
        var ue=UE.getEditor("ueditor");
        ue.ready(function(){
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行
            ue.execCommand('serverparam','_token','{{ csrf_token() }}');
            ue.setContent($('#content').val()); 
        });
        

        //文件上传    
        $("#upfile").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "{{url('fileupload')}}", //上传的地址
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            //uploadExtraData:{"id": 1, "fileName":'123.mp3'},
            uploadAsync: true, //默认异步上传
            showUpload: true, //是否显示上传按钮
            showRemove : true, //显示移除按钮
            showPreview : true, //是否显示预览
            showCaption: false,//是否显示标题
            browseClass: "btn btn-primary", //按钮样式     
            dropZoneEnabled: false,//是否显示拖拽区域
            //minImageWidth: 50, //图片的最小宽度
            //minImageHeight: 50,//图片的最小高度
            //maxImageWidth: 1000,//图片的最大宽度
            //maxImageHeight: 1000,//图片的最大高度
            maxFileSize: 20480,//单位为kb，如果为0表示不限制文件大小
            //minFileCount: 0,
            maxFileCount: 10, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount:true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
        });
    //异步上传返回结果处理
    $('#upfile').on('fileerror', function(event, data, msg) {
    });
    //异步上传返回结果处理
    $("#upfile").on("fileuploaded", function (event, data, previewId, index) {
                    var obj = data.response;
                   // console.log(data);
                    // alert(obj.state);
                    $('#cover').val(obj.data.url);
                });

    //同步上传错误处理
    $('#upfile').on('filebatchuploaderror', function(event, data, msg) {
                console.log(data.id);
                console.log(data.index);
                console.log(data.file);
                console.log(data.reader);
                console.log(data.files);
                // get message
                // alert(msg);
             });
       //同步上传返回结果处理
   $("#upfile").on("filebatchuploadsuccess", function (event, data, previewId, index) {
      });

    //上传前
    $('#upfile').on('filepreupload', function(event, data, previewId, index) {
            var form = data.form, files = data.files, extra = data.extra,
                response = data.response, reader = data.reader;
            // console.log('File pre upload triggered');
        });
    </script>
@endsection