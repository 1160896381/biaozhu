@extends('_layouts.app')

@section('content')

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <ol class="carousel-indicators">
	        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	        <li data-target="#myCarousel" data-slide-to="1"></li>
	        <li data-target="#myCarousel" data-slide-to="2"></li>
	        <li data-target="#myCarousel" data-slide-to="3"></li>
	    </ol>

	    <div class="carousel-inner" role="listbox">
	        <div class="item active">
	          	<img src="/images/01.jpg">
	        </div>
	        <div class="item">
	          	<img src="/images/02.jpg">
	        </div>
	        <div class="item">
	          	<img src="/images/03.jpg">
	        </div>
	        <div class="item">
	          	<img src="/images/04.jpg">
	        </div>
	    </div>

	    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	        <span class="sr-only">Previous</span>
      	</a>
      	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	        <span class="sr-only">Next</span>
      	</a>
	</div>

	<div class="container">
	    <div class="row">
	        <div class="col-lg-12">
	            <h2 class="page-header">
	                <div style="font-family:黑体">标注平台特性</div>
	            </h2>
	        </div>
	        <div class="col-md-4">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4><i class="fa fa-fw fa-check"></i> 多人协同标注</h4>
	                </div>
	                <div class="panel-body">
	                    <p>灵活的标注流水线支持多个用户可以在不同的时间地点协同的完成一个语料标注任务。他们既可以协同地加工同一个语料的不同加工阶段，也可以协同的对同一个语料的同一个阶段进行多次加工。</p>
	                    <a href="info/more.html" class="btn btn-default">更多</a>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-4">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4><i class="fa fa-fw fa-gift"></i> 多模态语料标注</h4>
	                </div>
	                <div class="panel-body">
	                    <p>支持文本、图片、声音和视频的在线标注。标注形式简单快捷，标注结果可视化呈现。检索结果可直接关联到原始语料中的标注点。<br><br></p>
	                    <a href="info/more.html" class="btn btn-default">更多</a>
	                </div>
	            </div>
	        </div>
	        <div class="col-md-4">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4><i class="fa fa-fw fa-compass"></i> 可定制的标注规范</h4>
	                </div>
	                <div class="panel-body">
	                    <p>可扩展的树状规范定义结构，不依赖于任何一种既有的标注规范，标注的管理者可以自定义规范，该规范可以在语料标注时自动更新，而这些对于标注者来说是透明的。</p>
	                    <a href="info/more.html" class="btn btn-default">更多</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop

@section('footer')
	<script>
	$(function(){
		$('#myCarousel').carousel({
	  		interval: 2000
		})
	})
	</script>
@stop