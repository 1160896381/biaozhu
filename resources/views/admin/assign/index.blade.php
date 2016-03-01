@extends('_layouts.admin')

@section('contentAdmin')

<div id="page-wrapper">
	<div class="row">
	    <div class="col-sm-12">     
	      
	        <table id="assign-table" class="table table-striped table-bordered">
	            <thead>
	                <tr>
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

@include('admin.partials.modals')

@endsection

@section('script')
<script>

    // 初始化数据
    $(function() {
        $("#assign-table").DataTable();
    });
</script>
@endsection