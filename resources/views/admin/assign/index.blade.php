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

				 {{-- 所有文件 --}}
				@foreach ($assigns as $assign)
				    <tr>
				        <td>
				            {{ $assign['title'] }}
				        </td>
				        <td>
				            {!! GetClaimtype($assign['claim']) !!}
				        </td>
				        <td>
				        	{{ $assign['updated_at']->format('j-M-y g:ia') }}
			        	</td>
				        <td>
				        	@if (isset($assign['finishTime']))
								{{ $assign['finishTime'] }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	@if (isset($assign['deadTime']))
								{{ $assign['deadTime'] }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	{{ $assign['labeler'] }}
			        	</td>
			        	<td>
				        	{{ $assign['state'] }}
			        	</td>
				        <td>
				            <button type="button" class="btn btn-xs btn-info" onclick="assign_task()">
				                <i class="fa fa-code-fork fa-lg"></i>
				                分配
				            </button>
				            <button type="button" class="btn btn-xs btn-danger">
				                <i class="fa fa-times-circle fa-lg"></i>
				                删除
				            </button>
				            <button type="button" class="btn btn-xs btn-warning">
				                <i class="fa fa-bug fa-lg"></i>
				                审核
				            </button>
				        </td>
				    </tr>
				@endforeach

	            </tbody>
	        </table>
	    </div>
	</div>
</div>

@include('admin.partials.modals')

@endsection

@section('script')
<script>

	// 分配任务
	function assign_task() {
	    $("#modal-task-assign").modal("show");
	}

    // 初始化数据
    $(function() {
        $("#assign-table").DataTable();
    });
</script>
@endsection