{{-- 删除文件 --}}
<div class="modal fade" id="modal-file-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">请确认</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    你确定要删除
                    <kbd><span id="delete-file-name1">file</span></kbd>
                    ?
                </p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/admin/resource/file">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="del_file_name" id="delete-file-name">
                    <input type="hidden" name="del_file_id" id="delete-file-id">
                    <input type="hidden" name="del_file_path" id="delete-file-path">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-danger">
                        删除文件
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- 上传文件 --}}
<div class="modal fade" id="modal-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/resource/file" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">上传新资源</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">
                            File
                        </label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_name" class="col-sm-3 control-label">
                            可选资源名
                        </label>
                        <div class="col-sm-4">
                            <input type="text" id="file_name" name="file_name" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary">
                        上传资源
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 浏览图片 --}}
<div class="modal fade" id="modal-image-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">图片预览</h4>
            </div>
            <div class="modal-body">
                <img id="preview-image" class="img-responsive">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 分配任务 --}}
<div class="modal fade" id="modal-task-assign">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/assign/task" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div type="hidden" name="current_claim" id="current-claim"></div>
                <input type="hidden" name="task_flag" id="task-flag">
                <input type="hidden" name="assign_id" id="assign-id">
                <input type="hidden" name="class_id" id="class-id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">分配任务</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label for="claim" class="col-sm-3 control-label">
                            任务状态
                        </label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="claim" id="fenpei" value="6" onclick="select_radio(6)" checked> 只分配
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="claim" id="fabu" value="1" onclick="select_radio(1)"> 发布
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="claim" id="jiaodui" value="3" onclick="select_radio(3)"> 校对
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="claim" id="wancheng" value="4" onclick="select_radio(4)"> 完成
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="task-assign-outter">
                        <label for="task-assign" class="col-sm-3 control-label">
                            任务分配
                        </label>
                        <div class="col-sm-8" id="task-assign">
                            <div style="width: 40%; float: left; margin-right: 2%">
                                <select name="state" class="form-control">
                                  <option value="0">请选择</option>
                                </select>
                            </div>
                            <div style="width: 40%; float: left">
                                <select name="state2" class="form-control">
                                  <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="dead-time-outter">
                        <label for="dead-time" class="col-sm-3 control-label">
                            截止时间
                        </label>
                        <div class="col-sm-4">
                            <input type="text" name="deadTime" id="dead-time" class="test-style width150 form-control" value="<?=date('Y-m-d H:i:s', time())?>">
                        </div>
                    </div>
                    <div class="form-group" id="labeler-outter">
                        <label for="labeler" class="col-sm-3 control-label">
                            标注者
                        </label>
                        <div class="col-sm-4">
                            <select id="labeler" class="selectpicker" name="labeler[]" multiple data-live-search="true">
                                @if (isset($labelers))
                                    @foreach ($labelers as $labeler)
                                        <option data-id={{ $labeler['id'] }}>
                                            {{ $labeler['labelerName'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">
                            说明
                        </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="2" id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="return valid_before_submit()">
                        提交
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 注册标注者 --}}
<div class="modal fade" id="modal-labeler-register">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/admin/labeler/register" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">注册标注者</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">姓名</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="labelerName" value="{{ old('labelerName') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">邮箱</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码确认</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 查看标注者完成的任务 --}}
<div class="modal fade" id="modal-labeler-see">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
                <button type="submit" class="btn btn-danger">
                    
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 修改标注者信息 --}}
<div class="modal fade" id="modal-labeler-modify">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
                <button type="submit" class="btn btn-danger">
                    
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 删除标注者 --}}
<div class="modal fade" id="modal-labeler-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
                <button type="submit" class="btn btn-danger">
                    
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 登录 --}}
<div class="modal fade" id="modal-member-login">
    <div class="modal-dialog" style="margin-top: 100px; width: 500px">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab0" data-toggle="tab">标注者</a>
                    </li>
                    <li>
                        <a href="#tab1" data-toggle="tab">管理员</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">超级管理员</a>
                    </li>
                </ul>
                <div class="tab-content" style="min-height: 200px">
                    <div class="tab-pane active tab-norm" id="tab0">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/labeler/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-3 control-label">邮箱</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">密码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> 记住我
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px">登录</button>
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                                    <a class="btn btn-link" href="{{ url('/password/email') }}">忘记密码?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane tab-norm" id="tab1">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/admin/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-3 control-label">邮箱</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">密码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> 记住我
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px">登录</button>
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                                    <a class="btn btn-link" href="{{ url('/password/email') }}">忘记密码?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane tab-norm" id="tab2">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/super/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-3 control-label">邮箱</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">密码</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> 记住我
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 10px">登录</button>
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>

                                    <a class="btn btn-link" href="{{ url('/password/email') }}">忘记密码?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 新建子课题 --}}
<div class="modal fade" id="modal-super-proj">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/super/proj/create" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">新建子课题</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">姓名</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-md-3 control-label">
                            说明
                        </label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="2" id="description" name="description"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                新建
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 注册管理员 --}}
<div class="modal fade" id="modal-super-admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/super/admin/create" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">注册管理员</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">姓名</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">邮箱</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码确认</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">选择所属项目</label>
                        <div class="col-md-6">
                            <select id="projId" class="form-control" name="projId">
                                @if (isset($projs))
                                    @foreach ($projs as $proj)
                                        <option value="{{ $proj['id'] }}">
                                            {{ $proj['name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">选择面板</label>
                        <div class="col-md-6">
                            <select id="projId" class="form-control" name="projId">
                                @if (isset($projs))
                                    @foreach ($projs as $proj)
                                        <option value="{{ $proj['id'] }}">
                                            {{ $proj['name'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 注册面板 --}}
<div class="modal fade" id="modal-super-flash">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/super/flash/create" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">注册面板</h4>
                </div>  
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">类型</label>
                        <div class="col-md-6">
                            <label class="radio-inline">
                              <input type="radio" value="1" name="classId" checked> 文本
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="2" name="classId"> 图片
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="3" name="classId"> 音频
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="4" name="classId"> 视频
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">需要规范</label>
                        <div class="col-md-6">
                            <label class="radio-inline">
                              <input type="radio" value="1" name="hasNorm" checked> 是
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="0" name="hasNorm"> 否
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label">需要浏览面板</label>
                        <div class="col-md-6">
                            <label class="radio-inline">
                              <input type="radio" value="1" name="hasBS" checked> 是
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="0" name="hasBS"> 否
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">工作路径</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="flashPath">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">浏览路径</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="flashPathBS">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                注册
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

