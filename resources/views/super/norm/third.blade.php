@extends('_layouts.super')

@section('contentSuper')

<div id="page-wrapper">

	<ul class="nav nav-tabs" id="detail-nav">
		@for ($i = 0; $i < count($firstKeys); $i++)
			@if ($i == 0) 
				@if (App\Norm::find($firstIds[0])->belongsToFlash['hasNorm'] == 0)
					<li class="active disabled">
						<a href="#" data-toggle="tab">
							<div 
								num-index=0 
								second-level="{{ $second[$secondKeys[0]] }}">
								{{ $firstKeys[0] }}
							</div>
						</a>
					</li>
				@else
					<li class="active">
						<a href="#tab0" data-toggle="tab">
							<div 
								num-index=0 
								second-level="{{ $second[$secondKeys[0]] }}">
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
							second-level="{{ $second[$secondKeys[$i]] }}">
						{{ $firstKeys[$i] }}
						</div>
					</a>
				</li>
			@else
				<li>
					<a href="#tab{{ $i }}" data-toggle="tab">
						<div 
							num-index={{ $i }} 
							second-level="{{ $second[$secondKeys[$i]] }}">
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
			  		<table class="table table-bordered table-condensed">
			  			<tr>
			  				<td style="width: 100px;">二级规范</td>
			  				<td>具体名称</td>
			  			</tr>
			  			@for ($j=0; $j<count(explode(',', $first[$firstKeys[$i]])); $j++)
			  			<tr>
			  				<td>{{ explode(',', $first[$firstKeys[$i]])[$j] }}</td>
			  				<td id="tag{{ '0A'.$j }}"></td>
			  			</tr>
			  			@endfor
			  		</table>
				</div>
			@else
				<div class="tab-pane tab-norm" id="tab{{ $i }}">
			  		<table class="table table-bordered table-condensed">
				  		<tr>
				  			<td style="width: 100px;">二级规范</td>
				  			<td>具体名称</td>
				  		</tr>
			  			@for ($j=0; $j<count(explode(',', $first[$firstKeys[$i]])); $j++)
			  			<tr>
			  				<td>{{ explode(',', $first[$firstKeys[$i]])[$j] }}</td>
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
			
			for (var i=0; i<li_size; i++) {
				var tr_size = $("#tab" + i + " tr").size();
				for (var j=0; j<tr_size; j++) {
					tab_val.push(
						$("#tag" + i + "A" + j)
							.getTabVals()
							.join(',')
							.replace(/\+/gi, '＋')
						?
						$("#tag" + i + "A" + j)
							.getTabVals()
							.join(',')
							.replace(/\+/gi, '＋')
						:
						'NULL'
					)
					// 小类分割线
					tab_val.push(".");
				}
				
				tab_val.pop();	// 去掉.
				tab_val.pop();	// 去掉空
				tab_val.pop();	// 去掉.

				// 大类分割线
				tab_val.push("。");
			}
		    tab_val.pop();	// 去掉。

		    var param = "tab_val=" + tab_val;
			
			// console.log(param)

		    $.ajax({
		        type: 'POST',
		        url: 'third',
		        data: encodeURI(param),
		        success: function() {
		        	alert('标注规范修改成功！');
		        }
		    });
		});

	});
</script>
@endsection
