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
	                    <th>标题</th>
	                    <th>类型</th>
	                    <th>发布时间</th>
	                    <th>截止时间</th>
	                    <th>完成时间</th>
	                    <th>任务</th>
	                    <th data-sortable="false">操作</th>
	                </tr>
	            </thead>
	            <tbody>
					@foreach ($assigns as $assign)
				    <tr>
				        <td>
				            {{ $assign['id'] }}
				        </td>
				        <td>
				            {{ $assign['title'] }}
				        </td>
				        <td>
				        	{{ GetClasstype($assign['classId']) }}
				        </td>
				        <td>
				        	{{ $assign['updated_at']->format('j-M-y g:ia') }}
			        	</td>
	    	        	<td>
	    		        	@if (isset($assign['deadTime']))
	    						{{ $assign['deadTime']->format('j-M-y g:ia') }}
	    					@else
	    						--
	    		        	@endif
	    	        	</td>
				        <td>
				        	@if (isset($assign['finishTime']))
								{{ $assign['finishTime']->format('j-M-y g:ia') }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	@if (isset($assign['state']) && isset($assign['state2']))
				        		{{ $stateArr[$assign['state']-1].'///'.$stateArr[$assign['state2']-1] }}
				        	@endif
			        	</td>
				        <td>
			                <a href="/labeler/assign/label/{{ $assign['id'] }}">
				        	    <button type="button" class="btn btn-xs btn-info" onclick="">
				                	<i class="fa fa-cogs fa-lg"></i>工作
				            	</button>
		                	</a>
			                <a href="/labeler/assign/check/{{ $assign['id'] }}">
				        	    <button type="button" class="btn btn-xs btn-danger">
				                	<i class="fa fa-eye fa-lg"></i>查看
				        	    </button>
		                	</a>
				        </td>
				    </tr>
				@endforeach
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

	var labeler_ls = '<?php echo \Auth::user()->labelerName; ?>';
	localStorage.setItem("labeler_ls", labeler_ls);
})
</script>
@endsection