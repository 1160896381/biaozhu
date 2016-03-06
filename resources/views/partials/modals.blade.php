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
                                @foreach ($labelers as $labeler)
                                    <option data-id={{ $labeler['id'] }}>
                                        {{ $labeler['labelerName'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-sm-3 control-label">
                            说明
                        </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" rows="2" id="content" name="content"></textarea>
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
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="labelerName" value="{{ old('labelerName') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Register
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