@extends('_layouts.admin')

@section('style')
<link href="/css/webuploader.css" rel="stylesheet">
<link href="/css/diyUpload.css" rel="stylesheet">
<style>
	*{ margin:0; padding:0;}
	#first{ width:100%; min-height:400px; background:#FF9; margin-bottom: 10px}
	#second{ width:100%; min-height:400px; background:#CF9}
</style>
@endsection

@section('contentAdmin')
<div id="page-wrapper">
	<div id="first">
		<div id="text" ></div>
	</div>

	<div id="second">
		<div id="pic" ></div>
	</div>
</div>
@endsection

@section('script')
<script src="/js/webuploader.js"></script>
<script src="/js/diyUpload.js"></script>
<script>
	/*
	* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
	* 其他参数同WebUploader
	*/

	$('#text').diyUpload({
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

	$('#pic').diyUpload({
		url:'/admin/resource/batch/file',
		success:function( data ) {console.info( data ); },
		error:function( err ) { console.info( err ); },
		buttonText:'点击选择图片',
		//是否已二进制的流的方式发送文件，这样整个上传内容php://input都为文件内容
		sendAsBinary:false,
		// 开起分片上传。 thinkphp的上传类测试分片无效,图片丢失;
		chunked:true,
		// 分片大小，这里要设的大一点，sunli
		chunkSize:512 * 1024 * 1024 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
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
</script>
@endsection