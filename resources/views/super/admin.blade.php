@extends('_layouts.super')

@section('style')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="/css/jquery.ui.datepicker.css" rel="stylesheet">
@endsection

@section('contentSuper')

<div id="page-wrapper">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-super-admin">
                <i class="fa fa-graduation-cap"></i> 注册管理员
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            @include('partials.errors')     
            @include('partials.success')  
        
            <table id="super-admin-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>邮箱</th>
                        <th>项目</th>
                        <th>注册时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>
                                {{ $admin['id'] }}
                            </td>
                            <td>
                                {{ $admin['name'] }}
                            </td>
                            <td>
                                {{ $admin['email'] }}
                            </td>
                            <td>
                                {{ App\User::find($admin['projId'])->proj['name'] }}
                            </td>
                            <td>
                                {{ $admin['updated_at']->format('j-M-y g:ia') }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-xs btn-info" onclick="see_labeler()">
                                    <i class="fa fa-eye fa-lg"></i>
                                    查看
                                </button>
                                <button type="button" class="btn btn-xs btn-warning" onclick="modify_labeler()">
                                    <i class="fa fa-eraser fa-lg"></i>
                                    修改
                                </button>
                                <button type="button" class="btn btn-xs btn-danger" onclick="delete_labeler()">
                                    <i class="fa fa-times-circle fa-lg"></i>
                                    删除
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
<script>
$(function(){

	$("#super-admin-table").DataTable();

})
</script>
@endsection