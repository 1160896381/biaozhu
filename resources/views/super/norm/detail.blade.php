@extends('_layouts.super')

@section('contentSuper')

<div id="page-wrapper">

	<ul class="nav nav-tabs" id="detail-nav">
		@for ($i = 0; $i < count($types); $i++)
			@if ($i == 0) 
				<li class="active">
					<a href="#tab0" data-toggle="tab">
						<div num-index=0 first-level="{{ $types[0]['firstLevel'] }}" second-level="{{ $types[0]['secondLevel'] }}">
							{{ $types[0]['zeroLevel'] }}
						</div>
					</a>
				</li>
			@elseif (App\Norm::find($types[$i]['id'])->belongsToFlash['hasNorm'] == 0)
				<li class="disabled"><a href="#tab{{ $i }}">
					<div num-index={{ $i }} first-level="{{ $types[$i]['firstLevel'] }}" second-level="{{ $types[$i]['secondLevel'] }}">
						{{ $types[$i]['zeroLevel'] }}
					</div>
				</a></li>
			@else
				<li><a href="#tab{{ $i }}" data-toggle="tab">
					<div num-index={{ $i }} first-level="{{ $types[$i]['firstLevel'] }}" second-level="{{ $types[$i]['secondLevel'] }}">
						{{ $types[$i]['zeroLevel'] }}
					</div>
				</a></li>			
			@endif
		@endfor
	</ul>

	<div class="tab-content" style="min-height: 200px">
		@for ($i = 0; $i < count($types); $i++)
			@if ($i == 0)
				<div class="tab-pane active tab-norm" id="tab0">
			  		<table class="table table-bordered table-condensed">
			  			@for ($j=0; $j < count(explode(',', $types[0]['firstLevel'])); $j++)
			  			<tr>
			  				<td style="min-width: 50px;">{{ explode(',', $types[0]['firstLevel'])[$j] }}</td>
			  				<td id="tag{{ '0A'.$j }}"></td>
			  			</tr>
			  			@endfor
			  		</table>
				</div>
			@else
				<div class="tab-pane tab-norm" id="tab{{ $i }}">
			  		<table class="table table-bordered table-condensed">
			  			@for ($j=0; $j < count(explode(',', $types[$i]['firstLevel'])); $j++)
			  			<tr>
			  				<td style="min-width: 50px;">{{ explode(',', $types[$i]['firstLevel'])[$j] }}</td>
			  				<td id="tag{{ $i.'A'.$j }}"></td>
			  			</tr>
			  			@endfor
			  		</table>
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

		var li_size = $("#detail-nav li").length

		for (var i=0; i<li_size; i++) {
			var tr_size = $("#tab" + i + " tr").size();
			for (var j=0; j<tr_size; j++) {
				var second_level = $("div[num-index=" + i + "]").attr("second-level");
				var second_level_array = second_level.split(".");
				// console.log(second_level.split("."));
				$("#tag" + i + "A" + j).tabControl(
					{ maxTabCount:100, tabW:80 }, 
					second_level_array[j]
				);
			}
		}
		
		// 注意合法字符里不能含有“.”以及“。”
		$("#getTab").click(function() {
			var tab_val = [];
			console.log(li_size);		    
			for (var i=0; i<li_size; i++) {
				var tr_size = $("#tab" + i + " tr").size();
				for (var j=0; j<tr_size; j++) {
					tab_val.push($("#tag" + i + "A" + j).getTabVals());
					tab_val.push(".");
				}
				tab_val.push("。");
			}
		    // console.log(typeof(tab_val))
		    var param = "tab_val=" 
	    			+ tab_val
	    				.join(",")
	    				.replace(/([\.|。]$)/, "")
    					.replace(/\+/gi, '＋');
			
		    $.ajax({
		        type: 'POST',
		        url: 'detail',
		        data: encodeURI(param),
		        success: function() {
		        	alert('标注规范修改成功！');
		        }
		    });
		});

	});
</script>
@endsection
