@extends('layouts.admin')
@section('title')
    {{$node['id']?'修改角色':'添加角色'}}
@endsection
@section('css')

@endsection
@section('content')

    <article class="page-container">
        @if($node['id'])
            <form action="{{route('admin.nodes.update',['nodes'=>$node['id']])}}" class="form form-horizontal">
                {{ method_field('PUT') }}
                {{--{{ method_field('post') }}--}}
                @else
                    <form action="{{route('admin.nodes.store')}}" enctype="multipart/form-data"
                          class="form form-horizontal">
                        {{ method_field('post') }}
                        @endif
                        {{csrf_field()}}
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="" placeholder="" name="node_name">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">父级权限：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                 <span class="select-box" style="width:150px;">
                                     <select class="select" name="pid" size="1">
                                        <option value="0">作为顶级权限</option>
                                         <option value="1">作为顶级权限</option>
                                          <option value="0">作为顶级权限</option>
                                         {{--@foreach($parents as $val)--}}

                                         {{--<option value="{{$val->id}}">{{str_repeat('----',$val->level)}}{{$val->auth_name}}</option>--}}
                                         {{--@endforeach--}}

                                     </select>
                                 </span>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>作为菜单：</label>
                            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                                <div class="radio-box">
                                    <input name="is_menu" type="radio" value="1" checked>
                                    <label for="is_nav-1">是</label>
                                </div>
                                <div class="radio-box">
                                    <input type="radio" value="0" name="is_menu" >
                                    <label for="is_nav-2">否</label>
                                </div>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">矢量图标：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" placeholder="" id="icon" name="icon">
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="" placeholder="" id="route_name"
                                       name="route_name">
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
        $(function () {
            //初始化默认隐藏
            $('#route_name').parents('.row').hide();

            $('select').change(function () {
                var val=$(this).val();
                // $('#icon,#route_name').val('');
                if (val!=0){
                    $('#route_name').parents('.row').show(300);
                    $('#icon').parents('.row').hide();
                }else{
                    $('#route_name').parents('.row').hide();
                    $('#icon').parents('.row').show(300);
                }
            })
        });
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
        $("form").validate({
            rules: {
                node_name: {
                    required: true,
                    minlength: 2,
                    // isChinese:true
                }
            },
            message: {
                node_name: {
                    required: '角色名称必须写',
                },
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                // $(form).submit();
                $(form).ajaxSubmit({
                    // type: $('form').attr("method"),
                    type: $('input[name=_method]').val(),
                    url: $('form').attr("action"),

                    success: function (data) {

                        if (data.msg == 'Success') {
                            layer.msg('{{$node['id']?'修改权限':'添加权限'}}成功!', {icon: 1, time: 2000}, function () {
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