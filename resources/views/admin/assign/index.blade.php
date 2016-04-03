@extends('_layouts.admin')

@section('style')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="/css/jquery.ui.datepicker.css" rel="stylesheet">
<link href="/css/bootstrap-select.css" rel="stylesheet">
@endsection

@section('contentAdmin')

<div id="page-wrapper">
	<div class="row">
	    <div class="col-sm-12">     
	      
	        <table id="assign-table" class="table table-striped table-bordered">
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
	                    <th data-sortable="false" width="150px">操作</th>
	                </tr>
	            </thead>
	            <tbody>

				 {{-- 所有文件 --}}
				@foreach ($assigns as $assign)
				    <tr>
				        <td>
				            {{ $assign['id'] }}
				        </td>
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
								{{ $assign['finishTime']->format('j-M-y g:ia') }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	@if (isset($assign['deadTime']))
								{{ $assign['deadTime']->format('j-M-y g:ia') }}
							@else
								--
				        	@endif
			        	</td>
			        	<td>
				        	{{ $assign['labeler'] }}
			        	</td>
			        	<td>
				        	@if (isset($assign['state']) && isset($assign['state2']))
				        		{{ $stateArr[$assign['state']-1].'///'.$stateArr[$assign['state2']-1] }}
				        	@endif
			        	</td>
				        <td>
				            <button type="button" 
				            	class="btn btn-xs btn-info" 
				            	onclick="assign_task({{ $assign['id'] }}, {{ $assign['classId'] }}, {{ $assign['userId'] }}, {{ $assign['claim'] }})">
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

@include('partials.modals')

@endsection

@section('script')
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.bootstrap.min.js"></script>
<script src="/js/jquery.ui.core.js"></script>
<script src="/js/jquery.ui.datepicker.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script>

	// 分配任务
	function assign_task(id, classId, userId, claim) {
		$("#assign-id").val(id);
		$("#class-id").val(classId);
		$("#current-claim").val(claim);
	    $("#modal-task-assign").modal("show");

	    // 防止重复加载，默认为“请选择”
	    if ($("select[name='state']")[0].length == 1) {
	    	ajax_from_xml(userId);
	    }

	    // 每次执行分配任务操作，给current_claim赋值
	    var cur = $("#current-claim").val();
	    if (cur==1 || cur==2 || cur==5) {
	    	$("#task-flag").val('CurrentTask');
	    } else {
	    	$("#task-flag").val('NewTask');
	    }
	}

	// 选择单选按钮
	function select_radio(change) {
		var cur = $("#current-claim").val();

		if (change == 6) {
			
			if (cur==5 || cur==1 || cur==2) {
				$("#task-flag").attr("value", "CurrentTask");
			} else {
				$("#task-flag").attr("value", "NewTask");
			}

			$("#task-assign-outter").show();
			$("#labeler-outter").show();
			$("#dead-time-outter").show();

		} else if (change == 1) {

			if (cur == 5) {
				$("#task-flag").attr("value", "CurrentTask");
			} else {
				$("#task-flag").attr("value", "NewTask");
			}
			
			for (var i=0; i<$("#labeler option").length; i++) {
				$("#labeler option")[i].selected = false;
			}

			$("#task-assign-outter").show();
			$("#dead-time-outter").show();
			$("#labeler-outter").hide();

		} else if (change == 3) {
			
			$("#task-flag").attr("value", "CurrentTask");
			$("#task-assign-outter").show();
			$("#dead-time-outter").show();
			$("#labeler-outter").show();			
		
		} else if (change == 4) {

			$("#task-flag").attr("value", "CurrentTask");
			$("#task-assign-outter").hide();
			$("#dead-time-outter").hide();
			$("#labeler-outter").hide();
		
		}
	}

	// 提交前验证
	function valid_before_submit() {
		if (!$("#wancheng:checked").val()) { // 在没有选择“完成”的情况下

			// 如果state下拉框选择的是“请选择”，alert
			if ($("select[name='state'] option:selected").val() == 0) {
				alert("请选择分配状态！");
				return false;
			}

			if ($("select[name='state'] option:selected").val()==0 
				&& $("select[name='state']").style.display!='none') {
				alert("请选择分配状态！");
				return false;	
			}
			if (!$("#dead-time").val()) {
				alert("请选择截止日期！");
				return false;
			}
			
			if (!$("#fabu:checked").val()) { // 在没有选择“发布”的情况下
				
				if ($("#jiaodui:checked").val() || $("#fenpei:checked").val()) { // 如果“校对”或者“分配”被选择了
					
					for (var i=0; i<$("#labeler option").length; i++) {
						
						if ($("#labeler option")[i].selected) {
							return true;
						} else {
						  continue;
						}
					}

					alert("请选择标注者！");
					return false;
				}
			}
		}
		return true;
	}

	function ajax_from_xml(userId) {

		var url = "/flash/assets/xml/label_types_" + userId + ".xml";
	    // 从xml中读取一级规范,用ajax进行异步加载操作
	    $.ajax({
	        url: url,
	        type: "post",
	        dataType: 'xml',
	        // 这里的msg是url中所指xml的内容
	        success: function(msg) {
	            // 先在xml中找到Layer1这个元素,找到之后利用each遍历
	            $(msg).find("Layer1").each(function() {
	                // 如果Layer1中的classid属性和网页中classid的val值相同
	                if ($(this).attr("classid") == $("#class-id").val()) {
	                    // 构建$option字符串
	                    $option = "<option value='" + $(this).attr("layerID") + "'>" + $(this).attr('label') + "</option>";
	                    // 通过append方法加入到下拉菜单state中
	                    $("select[name='state']").append($option);
	                }
	            });
	        },
	        error: function() {
	            alert('load xml error!');
	        }
	    });
	    // 当选择完一级规范后,依据一级规范确定二级规范
	    $("select[name='state']").change(function() {
	        // 得到state中被选中option的value值
	        var $proId = $("select[name='state'] option:selected").attr("value");
	        var url = "/flash/assets/xml/label_types_" + userId + ".xml";

	        $.ajax({
	            url: url,
	            type: "post",
	            dataType: "xml",
	            success: function(msg) {
	                // 先将下拉菜单state2中的内容清空
	                $("select[name='state2']").empty();
	                // 再将xml文件中layerID为$proId的那个状态找到
	                $state = $(msg).find("Layer1[layerID=" + $proId + "]");
	                // 这里只针对gf为1的state列出state2
	                if ($state.attr("gf") == 1) {
	                    var $option = "<option value='" + $proId + "'>不限</option>";
	                    $("select[name='state2']").append($option);
	                    $state.find("Layer2").each(function() {
	                        var $option = "<option value='" + $(this).attr("layerID") + "'>" + $(this).attr('label') + "</option>";
	                        $("select[name='state2']").append($option);
	                    });
	                } else {
	                    // 而对于gf不为1的state，只需显示无即可
	                    var add = Number($proId) + 1;
	                    var option = "<option value='" + add + "'>无</option>";
	                    $("select[name='state2']").append(option);
	                }
	            },
	            error: function() {
	                alert('load fail!');
	            }
	        });
	    });
	}

    // 初始化数据
    $(function() {

        $("#assign-table").DataTable();

        $('.selectpicker').selectpicker();
        
        $("#dead-time").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });
</script>
@endsection