@extends('_layouts.admin')

@section('contentAdmin')

<div id="page-wrapper">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-labeler-register">
                <i class="fa fa-user"></i> 注册标注者
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            
            @include('admin.partials.errors')     
            @include('admin.partials.success')       
            
            <table id="resource-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                        <th>审核状态</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                </thead>
                <tbody>
					 {{-- 所有文件 --}}
					@foreach ($labelers as $labeler)
					    <tr>
					        <td>
					            {{ $labeler['id'] }}
					        </td>
					        <td>
					            {{ $labeler['labelerName'] }}
					        </td>
					        <td>
					        	{{ $labeler['updated_at']->format('j-M-y g:ia') }}
				        	</td>
				        	<td>
					        	{{ $labeler['verify'] }}
				        	</td>
				        	<td>
					            <button type="button" class="btn btn-xs btn-info" onclick="see_labeler()">
					                <i class="fa fa-eye fa-lg"></i>
					                查看
					            </button>
					            <button type="button" class="btn btn-xs btn-info" onclick="modify_labeler()">
					                <i class="fa fa-eraser fa-lg"></i>
					                修改
					            </button>
					            <button type="button" class="btn btn-xs btn-danger" onclick="delete_labeler()">
					                <i class="fa fa-times-circle fa-lg"></i>
					                删除
					            </button>
					            <button type="button" class="btn btn-xs btn-warning" onclick="verify_labeler()">
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

function see_labeler() {

	$("#modal-labeler-see").modal("show");
}

function modify_labeler() {
	
	$("#modal-labeler-modify").modal("show");
}

function delete_labeler() {
	
	$("#modal-labeler-delete").modal("show");
}

function verify_labeler() {
	
	$("#modal-labeler-verify").modal("show");
}
</script>
@endsection