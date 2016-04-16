@extends('_layouts.super')

@section('contentSuper')

<div id="page-wrapper">
	
	<ul class="nav nav-tabs" id="type-nav">
		@for ($i = 0; $i < count($norms); $i++)
			@if ($i == 0) 
				@if (App\Norm::find($norms[0]['id'])->belongsToFlash['hasNorm'] == 0)
					<li class="active disabled">
						<a href="#" data-toggle="tab">
							<div 
								num-index=0 
								flash-id="{{ $norms[0]['flashId'] }}"
								zero-level="{{ $norms[0]['zeroLevel'] }}"
								first-level="{{ $norms[0]['firstLevel'] }}">
								{{ $norms[0]['zeroLevel'] }}
							</div>
						</a>
					</li>
				@else
					<li class="active">
						<a href="#tab0" data-toggle="tab">
							<div 
								num-index=0 
								flash-id="{{ $norms[0]['flashId'] }}"
								zero-level="{{ $norms[0]['zeroLevel'] }}"
								first-level="{{ $norms[0]['firstLevel'] }}">
								{{ $norms[0]['zeroLevel'] }}
							</div>
						</a>
					</li>
				@endif
			@elseif (App\Norm::find($norms[$i]['id'])->belongsToFlash['hasNorm'] == 0)
				<li class="disabled">
					<a href="#">
						<div 
							num-index={{ $i }} 
							flash-id="{{ $norms[$i]['flashId'] }}"
							zero-level="{{ $norms[$i]['zeroLevel'] }}"
							first-level="{{ $norms[$i]['firstLevel'] }}">
							{{ $norms[$i]['zeroLevel'] }}
						</div>
					</a>
				</li>			
			@else
				<li>
					<a href="#tab{{ $i }}" data-toggle="tab">
						<div 
							num-index={{ $i }} 
							flash-id="{{ $norms[$i]['flashId'] }}"
							zero-level="{{ $norms[$i]['zeroLevel'] }}"
							first-level="{{ $norms[$i]['firstLevel'] }}">
							{{ $norms[$i]['zeroLevel'] }}
						</div>
					</a>
				</li>			
			@endif
		@endfor
	</ul>

	<div class="tab-content" style="min-height: 200px">
		@for ($i = 0; $i < count($norms); $i++)
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
			for (var i=0; i<size; i++) {
				tab_val += $("#tag" + i).getTabVals()
						+ 'XXXXX' 
						+ $("div[num-index=" + i + "]").attr("flash-id") 
						+ 'XXXXX' 
						+ $("div[num-index=" + i + "]").attr("zero-level") 
						+ ' ';
			}
		    // console.log(tab_val)
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
