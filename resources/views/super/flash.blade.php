@extends('_layouts.super')

@section('style')
<link href="/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="/css/jquery.ui.datepicker.css" rel="stylesheet">
@endsection

@section('contentSuper')

<div id="page-wrapper">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-super-proj">
                <i class="fa fa-flash"></i> 新建面板
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table id="super-proj-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                        <th>邮箱</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                </thead>
                <tbody>

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

	$("#super-proj-table").DataTable();

	var super_ls = '<?php echo \Auth::user()->name; ?>';
	localStorage.setItem("super_ls", super_ls);
})
</script>
@endsection