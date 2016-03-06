@extends('_layouts.app')

@section('style')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="/css/jquery.ui.datepicker.css" rel="stylesheet">
@endsection

@section('contentApp')

<div id="labeler-page-wrapper">
	<div class="row" style="margin-top: 80px">
	    <div class="col-sm-8 col-sm-offset-2">     
	      
	        <table id="labeler-assign-table" class="table table-striped table-bordered">
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>文件名</th>
	                    <th>当前状态</th>
	                    <th>发布时间</th>
	                    <th>提交时间</th>
	                    <th>截止时间</th>
	                    <th>标注者</th>
	                    <th>任务</th>
	                    <th data-sortable="false">操作</th>
	                </tr>
	            </thead>
	            <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection


@section('script')
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap.min.js"></script>
<script>
$(function(){
	$("#labeler-assign-table").DataTable();
})
</script>
@endsection