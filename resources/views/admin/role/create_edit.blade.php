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
                    <input type="text" class="input-text" value="{{$role['id']?$role['role_name']:''}}" placeholder=""  name="role_name">
                </div>
            </div>
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
        $(function(){
            $(".permission-list dt input:checkbox").click(function(){
                $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
            });
            $(".permission-list2 dd input:checkbox").click(function(){
                var l =$(this).parent().parent().find("input:checked").length;
                var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
                if($(this).prop("checked")){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
                }
                else{
                    if(l==0){
                        $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                    }
                    if(l2==0){
                        $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                    }
                }
            });

        });
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