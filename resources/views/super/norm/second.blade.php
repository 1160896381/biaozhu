@extends('_layouts.super')

@section('contentSuper')

<div id="page-wrapper">
	
	<ul class="nav nav-tabs" id="type-nav">
		@for ($i = 0; $i < count($firstKeys); $i++)
			@if ($i == 0) 
				@if (App\Norm::find($firstIds[0])->belongsToFlash['hasNorm'] == 0)
					<li class="active disabled">
						<a href="#" data-toggle="tab">
							<div 
								num-index=0 
								flash-id="{{ $flashIds[0] }}"
								zero-level="{{ $firstKeys[0] }}"
								first-level="{{ $first[$firstKeys[0]] }}">
								{{ $firstKeys[0] }}
							</div>
						</a>
					</li>
				@else
					<li class="active">
						<a href="#tab0" data-toggle="tab">
							<div 
								num-index=0 
								flash-id="{{ $flashIds[0] }}"
								zero-level="{{ $firstKeys[0] }}"
								first-level="{{ $first[$firstKeys[0]] }}">
								{{ $firstKeys[0] }}
							</div>
						</a>
					</li>
				@endif
			@elseif (App\Norm::find($firstIds[$i])->belongsToFlash['hasNorm'] == 0)
				<li class="disabled">
					<a href="#">
						<div 
							num-index={{ $i }} 
							flash-id="{{ $flashIds[$i] }}"
							zero-level="{{ $firstKeys[$i] }}"
							first-level="{{ $first[$firstKeys[$i]] }}">
							{{ $firstKeys[$i] }}
						</div>
					</a>
				</li>			
			@else
				<li>
					<a href="#tab{{ $i }}" data-toggle="tab">
						<div 
							num-index={{ $i }} 
							flash-id="{{ $flashIds[$i] }}"
							zero-level="{{ $firstKeys[$i] }}"
							first-level="{{ $first[$firstKeys[$i]] }}">
							{{ $firstKeys[$i] }}
						</div>
					</a>
				</li>			
			@endif
		@endfor
	</ul>

	<div class="tab-content" style="min-height: 200px">
		@for ($i = 0; $i < count($firstKeys); $i++)
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
	
	<div class="row" style="margin-top: 20px">
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

		var size = $("#type-nav li").length;

		for (var i=0; i<size; i++) {
			$("#tag" + i).tabControl(
				{ maxTabCount:100, tabW:80 }, 
				$("div[num-index=" + i + "]").attr("first-level")
			);			
		}

		$("#getTab").click(function() {
			var tab_val = '';
			var tab_val_validate = '';

			for (var i=0; i<size; i++) {
				
				var get_tab_vals = $("#tag" + i).getTabVals();
				tab_val_validate += get_tab_vals;

				tab_val += get_tab_vals
						+ 'XXXXX' 
						+ $("div[num-index=" + i + "]").attr("flash-id") 
						+ 'XXXXX' 
						+ $("div[num-index=" + i + "]").attr("zero-level") 
						+ ' ';
			}

		    // console.log(tab_val_validate)
		    if (!tab_val_validate) {
		    	alert("请至少填写一份具体规范再提交！");
		    	return false;
		    }

		    var param = "tab_val=" + tab_val.replace(/(\s*$)/, "");
		    
		    $.ajax({
		        type: 'POST',
		        url: 'second',
		        data: encodeURI(param),
		        success: function() {
		        	window.location.href = 'third';
		        }
		    });
		});

	});
</script>
@endsection
