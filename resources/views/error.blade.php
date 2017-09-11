@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <style type="text/css">
    body{ background: #f5f2f2;}
    .container{ padding: 0; max-width: 736px;
        text-align: center;
        position: absolute;
        top: 50%;
        margin-top: -25px;
        width: 100%;
        left: 0;}

    </style>
@endsection
@section('content')
   <div class="container">
        <h3>页面不存在</h3>
   </div>
       
@endsection
@section('scripts')
     <script type="text/javascript">
    // 	var h =  document.body.clientHeight;
    // 	$('.footer').css('top',h-40);
     </script>
@endsection