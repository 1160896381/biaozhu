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
					@for ($i=0; $i<count($assigns); $i++)
				    <tr>
				        <td>
				            {{ $assigns[$i]['id'] }}
				        </td>
				        <td>
				            {{ $assigns[$i]['title'] }}
				        </td>
				        <td>
				        	{{ GetClasstype($assigns[$i]['classId']) }}
				        </td>
				        <td>
				        	{{ $assigns[$i]['updated_at']->format('j-M-y g:ia') }}
			        	</td>
	    	        	<td>
	    		        	@if (isset($assigns[$i]['deadTime']))
	    						{{ $assigns[$i]['deadTime']->format('j-M-y g:ia') }}
	    					@else
	    						--
	    		        	@endif
	    	        	</td>
				        <td>
				        	@if (isset($assigns[$i]['finishTime']))
								{{ $assigns[$i]['finishTime']->format('j-M-y g:ia') }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	@if (isset($assigns[$i]['state']) && isset($assigns[$i]['state2']))
				        		{{ $stateArr[$assigns[$i]['state']-1].'///'.$stateArr[$assigns[$i]['state2']-1] }}
				        	@endif
			        	</td>
				        <td>
			                <a href="/labeler/assign/label/{{ $assigns[$i]['id'] }}">
				        	    <button type="button" class="btn btn-xs btn-info" onclick="">
				                	<i class="fa fa-cogs fa-lg"></i>工作
				            	</button>
		                	</a>
			                	@if ($BSArr[$assigns[$i]['state']-1] == 1)
			                	<a href="/labeler/assign/check/{{ $assigns[$i]['id'] }}">
					        	    <button type="button" class="btn btn-xs btn-danger">
					                	<i class="fa fa-eye fa-lg"></i>查看
					        	    </button>
					        	</a>
					        	@elseif ($BSArr[$assigns[$i]['state']-1] == 0)
				        		    <button type="button" class="btn btn-xs btn-danger disabled">
				        	        	<i class="fa fa-eye fa-lg"></i>查看
				        		    </button>
				        	    @endif
		                	</a>
				        </td>
				    </tr>
				@endfor
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
	
	$('.disabled').click(function(event) {
	  	event.preventDefault();  
	});

	var labeler_ls = '<?php echo \Auth::user()->labelerName; ?>';
	localStorage.setItem("labeler_ls", labeler_ls);
})
</script>
@endsection