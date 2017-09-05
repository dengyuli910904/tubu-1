@extends('web.layouts.web')
@include('public.ueditor')
@section('title','徒步')
@section('styles')
    <style type="text/css">
    body{ background: #f5f2f2;}
    .row{ padding:5px 15px;}
    .user-img{ width: 45px;}
    .container{ padding: 0; max-width: 736px;}
    h3{ color: #333; margin:0px 0px;}
    section { margin: 0 0 10px 0; background: #fff; width: 100%; padding: 0;}
    section h4{ font-size: 15px; line-height: 20px; color: #999;}
    .act_group{ padding-left: 0px;}
    h4.act_title{
    	color: #999;
    }
    h4.act_title:before{
    	content: '';
    	width: 0;
    	height: 0;
    }
    section h4:before{ 
    		display: inline-block;
		    left: 0;
		    content: '';
		    position: relative;
		    height: 15px;
		    width: 2px;
		    top: 0;
		    background: #119100;
		    margin:-2px 10px;
    }
    .btn-follow{ background: #118F00; color: #fff; border: none; padding:3px 15px; border-radius: 5px; }
    hr{ margin-top: 5px; margin-bottom: 5px;}
    .footer{ text-align: center; height: 40px; font-size: 17px; 
    	width: 100%;position:fixed;left: 0; bottom: 0; 
    	background: #119100; color: #fff; line-height: 30px; margin: 0; overflow: hidden;}
    
    </style>
@endsection
@section('content')
    <div>
        <section>
        	<div class="row">
            	<img src="{{ asset('web/img/img.png')}}" class="img-responsive" />
            </div>

            <div class="row">
            	<div class="col-xs-8">
            		<h3>深圳湾徒步旅行团</h3>
            	</div>
            	<div class="col-xs-4">
            		<button class="btn-follow">关注</button>
            	</div>
            	
            </div>
            <div class="row">
            	<div class="col-xs-6">
            		<span class="label label-warning">即将开始</span>
            		<span class="label label-danger">徒步</span>
            		<span>￥98</span>
            	</div>
            	<!-- <div class="col-xs-6">
            		<span class="glyphicon glyphicon-eye-open" aria-hidden="true">关注：62</span>
            		|
            		<span class="glyphicon glyphicon-heart" aria-hidden="true">收藏：36</span>
            		
            	</div> -->
            </div>
            <hr/>
            <div class="row">
            	<div class="col-xs-6">
            		<p>开始时间：</p>
            		<p>2017-07-02 08：00</p>
            	</div>
            	<div class="col-xs-6">
            		<p>结束时间：</p>
            		<p>2017-07-02 08：00</p>
            	</div>
            </div>
        </section>
        
        <section>
        	<div class="row">
        		<div class="col-xs-4 act_group">
	        		<h4>所属圈子</h4>
            	</div>	
            	<div class="col-xs-8" style="text-align:right;">
            		<h4 class="act_title">徒步深圳湾旅团</h4>
            	</div>
        	</div>
        	<hr/>
        	<div class="row">
        		<div class="col-xs-4">
	        		<img src="{{ asset('web/img/user.png') }}" class="img-circle user-img">
	        		<label>Peter</label>
            	</div>	
            	<div class="col-xs-8" style="line-height:50px; text-align:right;">
            		12033333333
            	</div>
        	</div>
        	<hr/>
        	<div class="row">
        		<div class="col-xs-2 leader">
        			<img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
        		</div>
        		<div class="col-xs-2">
        			<img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
        		</div>
        		<div class="col-xs-2">
        			<img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
        		</div>
        		<div class="col-xs-2 add">
        			<img src="{{ asset('web/img/user.png')}}" class="img-circle user-img">
        		</div>
        		<div class="col-xs-4" style="line-height:50px;">
        			120/200人
        		</div>
        		<!-- <div class="col-xs-1">
        			<span class="glyphicon glyphicon-menu-right" aria-hidden="true"  style="line-height:50px;"></span>
        		</div> -->
        	</div>

        </section>

        <section>
        	<div class="row">
        		<h4>活动内容</h4>
        	</div>
        	<div class="row">
        		<div class="col-xs-12">
        			活动内容活动内容活动内容活动内容活动内容活动内容活动内容活动内容活动内容活动内容
        		</div>
        	</div>
        </section>
       
       <section style=" margin-bottom:60px;">
        	<div class="row">
        		<h4>活动费用</h4>
        	</div>
        	<div class="row">
        		<div class="col-xs-12">
        			活动费用活动费用活动费用活动费用活动费用活动费用活动费用活动费用活动费用活动费用
        		</div>
        	</div>
        </section>

        <!-- <section>
        	<p>留言</p>
        </section> -->

        <section class="footer">
        	<div class="row">
        			立即参加
        	</div>
        	<!-- <div class="col-xs-7">
        		<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
        		<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        	</div>
        	<div class="col-xs-5">报名</div> -->
        </section>
    </div>
@endsection
@section('scripts')
     <script type="text/javascript">
    // 	var h =  document.body.clientHeight;
    // 	$('.footer').css('top',h-40);
     </script>
@endsection