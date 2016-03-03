@extends('_layouts.admin')

@section('contentAdmin')

<div id="page-wrapper">
	
	<ul class="nav nav-tabs">
		@for ($i = 0; $i < 2; $i++)
			@if ($i == 0) 
				<li class="active">
					<a href="#tab0" data-toggle="tab">
						<div num-index=0 first-level="{{ $types[0]['firstLevel'] }}">
							{{ $types[0]['zeroLevel'] }}
						</div>
					</a>
				</li>
			@else
				<li><a href="#tab{{ $i }}" data-toggle="tab">
					<div num-index={{ $i }} first-level="{{ $types[$i]['firstLevel'] }}">
						{{ $types[$i]['zeroLevel'] }}
					</div>
				</a></li>			
			@endif
		@endfor
	</ul>

	<div class="tab-content" style="min-height: 200px">
		@for ($i = 0; $i < 2; $i++)
			@if ($i == 0)
				<div class="tab-pane active tab-norm" id="tab0">
			  		<p id="tag0"></p>
				</div>
			@else
				<div class="tab-pane tab-norm" id="tab{{ $i }}">
			  		<p id="tag{{ $i }}"></p>
				</div>
			@endif
		@endfor
	</div>
	

	<div class="row">
	    <div class="col-md-6">
	        <button type="button" class="btn btn-primary btn-md" id="getTab">
	            <i class="fa fa-send"></i> 提交
	        </button>
	    </div>
	</div>
</div>

@endsection

@section('script')
<script src="/js/tabControl.js"></script>
<script>
	$(function() {

		for (var i=0; i<2; i++) {
			$("#tag" + i).tabControl(
				{ maxTabCount:100, tabW:80 }, 
				$("div[num-index=" + i + "]").attr("first-level")
			);			
		}

		$("#getTab").click(function() {
			var tab_val = '';
			for (var i=0; i<2; i++) {
				tab_val += $("#tag" + i).getTabVals() + ' ';
			}
		    // console.log(typeof(tab_val))
		    var param = "tab_val=" + tab_val.replace(/(\s*$)/, "");
		    
		    $.ajax({
		        type: 'POST',
		        url: 'type',
		        data: encodeURI(param),
		        success: function() {
		            alert("请继续填写名称，否则规范不会更改！");
		            window.location.reload();
		        }
		    });
		});

	});
</script>
@endsection