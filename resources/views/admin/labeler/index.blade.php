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

                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.partials.modals')

@endsection

@section('script')
<script>
	

</script>
@endsection