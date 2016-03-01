@extends('_layouts.admin')

@section('contentAdmin')

<div id="page-wrapper">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-file-upload">
                <i class="fa fa-upload"></i> 上传资源
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
                        <th>文件名</th>
                        <th>文件类型</th>
                        <th>上传日期</th>
                        <th>文件大小</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                </thead>
                <tbody>

                 {{-- 所有文件 --}}
                @foreach ($resources as $file)
                    <tr>
                        <td>
                            <a href="{{ $file['webPath'] }}">
                                @if (is_image($file['mimeType']))
                                <i class="fa fa-file-image-o fa-lg fa-fw"></i>
                                @else
                                <i class="fa fa-file-o fa-lg fa-fw"></i>
                                @endif
                                {{ $file['fileName'] }}
                            </a>
                        </td>
                        <td>
                            @if (is_image($file['mimeType']))
                            图片
                            @elseif (is_text($file['mimeType']))
                            文本
                            @endif
                        <td>{{ $file['updated_at']->format('j-M-y g:ia') }}</td>
                        <td>{{ human_filesize($file['fileSize']) }}</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{ $file['fileReal'] }}', '{{ $file['fileName'] }}', '{{ $file['id'] }}', '{{ $file['type'] . '/' . $file['subPath'] }}')">
                                <i class="fa fa-times-circle fa-lg"></i>
                                Delete
                            </button>
                            @if (is_image($file['mimeType']))
                                <button type="button" class="btn btn-xs btn-success" onclick="preview_image('{{ $file['webPath'] }}')">
                                    <i class="fa fa-eye fa-lg"></i>
                                    Preview
                                </button>
                            @endif
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

    // 确认文件删除
    function delete_file(name1, name, id, path) {
        $("#delete-file-name1").html(name);
        $("#delete-file-id").val(id);
        $("#delete-file-name").val(name1);
        $("#delete-file-path").val(path);
        $("#modal-file-delete").modal("show");
    }

    // 预览图片
    function preview_image(path) {
        $("#preview-image").attr("src", path);
        $("#modal-image-view").modal("show");
    }

    // 初始化数据
    $(function() {
        $("#resource-table").DataTable();
    });
</script>
@endsection