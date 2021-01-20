@extends('layouts.admin')
@section('title')
{{$role['id']?'修改角色':'添加角色'}}
@endsection
@section('css')

@endsection
@section('content')

    <article class="page-container">
        @if($role['id'])
            <form action="{{route('admin.roles.update',['roles'=>$role['id']])}}"  class="form form-horizontal" >
                {{ method_field('PUT') }}
                {{--{{ method_field('post') }}--}}
                @else
                    <form action="{{route('admin.roles.store')}}"  enctype="multipart/form-data" class="form form-horizontal" >
                        {{ method_field('post') }}
                        @endif
                        {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$role['id']?$role['role_name']:''}}" placeholder="" id="role_name" name="role_name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">权限：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <table>
                        <tr>
                            <td>
                                {{--@foreach($data as $val)--}}
                                    {{--{{str_repeat('----',$val->level)}}<input name="auth_id[]" value="{{$val->id}}" level_id="{{$val->level}}"--}}
                                                                             {{--type="checkbox">{{$val->auth_name}}</br>--}}
                                {{--@endforeach--}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            {{--<div class="row cl">--}}
            {{--<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>作为导航：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9 skin-minimal">--}}
            {{--<div class="radio-box">--}}
            {{--<input name="is_nav" type="radio" value="1" id="is_nav-1" checked>--}}
            {{--<label for="is_nav-1">是</label>--}}
            {{--</div>--}}
            {{--<div class="radio-box">--}}
            {{--<input type="radio" id="is_nav-2" value="2" name="is_nav">--}}
            {{--<label for="is_nav-2">否</label>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>

@endsection
@section('js')
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>

    <script type="text/javascript">
        $("form").validate({
            rules: {
                role_name: {
                    required: true,
                    minlength: 2,
                    // isChinese:true
                }
            },
            message:{
                role_name:{
                    required:'角色名称必须写',
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
                            layer.msg('{{$role['id']?'修改角色':'添加角色'}}成功!', {icon: 1, time: 2000}, function () {
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