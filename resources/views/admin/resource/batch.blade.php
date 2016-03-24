@extends('_layouts.admin')

@section('style')
<link href="/css/diyUpload.css" rel="stylesheet">
@endsection

@section('contentAdmin')
<div id="page-wrapper">
	<ul class="nav nav-tabs" id="batch-nav">
		<li class="active">
			<a href="#tab0" id="text" data-toggle="tab">
				文本
			</a>
		</li>
		<li>
			<a href="#tab1" id="pic" data-toggle="tab">
				图片
			</a>
		</li>
	</ul>

	<div class="tab-content" style="min-height: 200px">
		<div class="tab-pane batch active" id="tab0">
	  		<div class="text"></div>
		</div>
		<div class="tab-pane batch" id="tab1">
	  		<div class="pic"></div>
		</div>		
	</div>
</div>
@endsection

@section('script')
<script src="/js/webuploader.js"></script>
<script src="/js/diyUpload.js"></script>
<script>
$(function() {

	$(".tab-pane.active").diyUpload({
		url:'/admin/resource/batch/file',
		success:function( data ) { console.info( data ); },
		error:function( err ) { console.info( err ); },
		buttonText:'点击选择文本',
		chunked:true,
		chunkSize:512 * 1024,
		fileNumLimit:100,
		fileSizeLimit:5000 * 1024,
		fileSingleSizeLimit:5000000 * 1024,
		accept:
		{
			title:"Texts",
			extensions:"txt",
			mimeTypes:"text/plain"
		}
	});

	$("#batch-nav #text").click(function() {
		$(".parentFileBox").remove();
		setTimeout(function() {
			$(".tab-pane.active").diyUpload({
				url:'/admin/resource/batch/file',
				success:function( data ) { console.info( data ); },
				error:function( err ) { console.info( err ); },
				buttonText:'点击选择文本',
				chunked:true,
				chunkSize:512 * 1024,
				fileNumLimit:100,
				fileSizeLimit:5000 * 1024,
				fileSingleSizeLimit:5000000 * 1024,
				accept:
				{
					title:"Texts",
					extensions:"txt",
					mimeTypes:"text/plain"
				}
			});
		}, 0);
	});

	$("#batch-nav #pic").click(function() {
		$(".parentFileBox").remove();
		setTimeout(function() {
			$(".tab-pane.active").diyUpload({
				url:'/admin/resource/batch/file',
				success:function( data ) {console.info( data ); },
				error:function( err ) { console.info( err ); },
				buttonText:'点击选择图片',
				sendAsBinary:false,
				chunked:true,
				chunkSize:512 * 1024 * 1024 * 1024,
				fileNumLimit:100,
				fileSizeLimit:5000 * 1024 * 1024,
				fileSingleSizeLimit:500 * 1024 * 1024 * 1024,
				accept:
				{
					title:"Images",
					extensions:"jpg,jpeg",
					mimeTypes:"image/*"
				}
			});
		}, 0);
	});
});
</script>
@endsection