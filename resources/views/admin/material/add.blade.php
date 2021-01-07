@extends('layouts.admin')
@section('title')

@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="/admin/lib/webuploader/0.1.5/webuploader.css"/>
@endsection
@section('content')
    <div class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-member-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">附件：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div id="uploader">
                        <!--用来存放item-->
                        <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker">选择图片</div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="avatar" value="">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box" style="width: 110px">
                <select class="select" size="1" name="counties_id" id="continent_id">
                 <option value="0" selected>临时</option>
                      <option value="1" >永久</option>
                </select>
                </span>
                </div>
            </div>
            {{csrf_field()}}
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>


@endsection
@section('js')

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script type="text/javascript" src="/js/getting-started.js"></script>
    <script type="text/javascript">
        $(function () {

            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $("#form-member-add").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 2,
                        maxlength: 16
                    },
                    mobile: {
                        required: true,
                        isMobile: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    counties_id: {
                        required: true,
                    },

                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "",
                        success: function (data) {
                            if (data == '1') {
                                layer.msg('添加成功!', {icon: 1, time: 2000}, function () {
                                    var index = parent.layer.getFrameIndex(window.name);
                                    // parent.$('.btn-refresh').click();
                                    parent.window.location = parent.window.location;
                                    parent.layer.close(index);
                                });
                            } else {
                                layer.msg('添加失败!', {icon: 2, time: 2000});
                            }

                        },
                        error: function (XmlHttpRequest, textis_nav, errorThrown) {
                            layer.msg('error!', {icon: 2, time: 1000});
                        }
                    });

                }

            });
        });
    </script>

@endsection