@extends('layouts.admin')
@section('title')
    {{$managers['id']?'修改管理员':'添加管理员'}}
@endsection
@section('css')

@endsection
@section('content')
    <div class="page-container">
        {{--表单验证提示--}}
        @include('admin.common.validate')
        @if($managers['id'])
            <form action="{{route('admin.managers.update',['managers'=>$managers['id']])}}" enctype="multipart/form-data" class="form form-horizontal" >
                {{ method_field('PUT') }}
                {{--{{ method_field('post') }}--}}
                @else
                    <form action="{{route('admin.managers.store')}}"  enctype="multipart/form-data" class="form form-horizontal" >
                        {{ method_field('post') }}
                        @endif
                        {{csrf_field()}}
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="{{$managers['username']}}" autocomplete="off" placeholder="输入用户名" id="username" name="username">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>真实姓名:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" value="{{$managers['truename']}}" name="truename" class="input-text">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="" placeholder="输入密码" id="password" name="password">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="" placeholder="输入确认密码"  name="password_confirmation">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                                <div class="radio-box">
                                    <input name="gender" type="radio" id="sex-1" value="1" checked >
                                    <label for="sex-1">男</label>
                                </div>
                                <div class="radio-box">
                                    <input type="radio" id="sex-2" name="gender" value="2">
                                    <label for="sex-2">女</label>
                                </div>
                                <div class="radio-box">
                                    <input type="radio" id="sex-3" name="gender" value="3">
                                    <label for="sex-3">保密</label>
                                </div>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="{{$managers['email']}}" placeholder="输入邮箱" id="email" name="email">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="{{$managers['mobile']}}" placeholder="输入手机号" id="mobile" name="mobile">
                            </div>
                        </div>
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序:</label>--}}
                            {{--<div class="formControls col-xs-8 col-sm-9">--}}
                                {{--<input type="text" value="{{$managers['sort']?$managers['sort']:'50'}}" name="sort" class="input-text">--}}
                            {{--</div>--}}
                        {{--</div>--}}
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
    <script type="text/javascript">
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        // 手机号码验证
        jQuery.validator.addMethod("isMobiles", function(value, element) {
            var length = value.length;
            var mobile = /^1[3-9]+\d{9}$/;
            var tel = /^\+86-1[3-9]+\d{9}$/;
            return this.optional(element) || tel.test(value) || (length==11 && mobile.test(value));
        }, "请输入正确手机号码或电话号码");
        $("form").validate({
            rules: {
                truename: {
                    required: true,
                    minlength: 2,
                    isChinese:true
                },
                username: {
                     required: true,
                     minlength: 2,
                     maxlength: 16
                 },
                password:{
                    required: true,
                    isPwd:true
                },
                confirmation_password:{
                    equalTo: '#password',
                },
                 mobile: {
                     required: true,
                     isMobiles: true,
                     // isMobile: true,
                 },
                email:{
                    required: true,
                    email: true,
                }
            },
            message:{
                truename:{
                    required:'真实姓名必须写',
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                // $(form).submit();
                $(form).ajaxSubmit({
                    // type: $('form').attr("method"),
                    type:$('input[name=_method]').val(),
                    url: $('form').attr("action"),

                    success: function (data) {

                        if (data.msg == 'Success') {
                            layer.msg('添加成功!', {icon: 1, time: 2000}, function () {
                                var index = parent.layer.getFrameIndex(window.name);
                                // parent.$('.btn-refresh').click();
                                parent.window.location = parent.window.location;
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg(data.msg, {icon: 2, time: 2000});
                            // layer.msg(data.data, {icon: 2, time: 2000});
                        }

                    },
                    error: function (XmlHttpRequest, textis_nav, errorThrown) {
                        layer.msg('error!', {icon: 2, time: 1000});
                    }
                });

            }

        });
    </script>

@endsection