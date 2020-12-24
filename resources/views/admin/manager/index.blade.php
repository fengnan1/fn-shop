@extends('layouts.admin')
@section('title')
 管理员列表
@endsection
@section('css')
    <link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
@endsection
@section('content')
    <div >
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span
                    class="c-gray en">&gt;</span> 产品列表 <a class="btn btn-success radius r"
                                                          style="line-height:1.6em;margin-top:3px"
                                                          href="javascript:location.replace(location.href);" title="刷新"><i
                        class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            {{csrf_field()}}
            <div class="text-c"> 日期范围：
                <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin"
                       class="input-text Wdate" style="width:120px;">

                <input type="text"
                       onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d %H:%m:%s' })"
                       id="logmax" class="input-text Wdate" style="width:120px;">
                <input type="text" name="" id="" placeholder=" 产品名称" style="width:250px" class="input-text">
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜产品
                </button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()"
                                                                       class="btn btn-danger radius"><i
                                class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius"
                                                                              onclick="goods_add('添加管理员','{{route('admin.managers.create')}}')"
                                                                              href="javascript:;"><i
                                class="Hui-iconfont">&#xe600;</i> 添加产品</a></span> <span
                        class="r">共有数据：<strong>54</strong> 条</span></div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="3%"><input type="checkbox" name="" value=""></th>
                        <th width="5%">ID</th>
                        <th width="8%">用户名</th>
                        <th width="10%">真实姓名</th>
                        <th width="5%">性别</th>
                        <th width="8%">手机号</th>
                        <th width="">邮箱</th>
                        <th width="7%">邮箱是否验证</th>
                        <th width="5%">排序</th>
                        <th width="">创建时间</th>
                        <th width="5%">账号状态</th>
                        <th width="">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $val)
                        <tr class="text-c va-m">
                            <td>
                                @if(auth('admin')->id()!=$val['id'])
                                <input name="" type="checkbox" value="{{$val['id']}}">
                                 @endif
                            </td>
                            <td>{{$val['id']}}</td>
                            <td class="text-l">{{$val['username']}}</td>
                            <td class="text-l">{{$val['truename']}}</td>
                            <td class="text-l">{{$val['gender']}}</td>
                            <td>{{$val['mobile']}}</td>
                            <td>{{$val['email']}}</td>
                            <td>{{$val['email_verified']}}</td>
                            <td>{{$val['sort']}}</td>
                            <td>{{$val['created_at']}}</td>
                            <td class="td-status">
                                @if($val['status']=='1')
                                    <span class="label label-success radius">启用</span>
                                @else
                                    <span class="label label-danger radius">停用</span>
                                @endif
                            </td>
                            <td class="td-manage">
                                @if($val['status']=='1')
                                    <a style="text-decoration:none" onClick="managers_stop(this,'{{route('admin.managers.stop',['managers'=>$val['id']])}}')"
                                       href="javascript:;" class="label label-danger radius" >停用</a>
                                @else
                                    <a style="text-decoration:none" onClick="managers_start(this,'{{route('admin.managers.start',['managers'=>$val['id']])}}')" href="javascript:;"
                                       class="label label-success radius">启用</a>
                                @endif
                                <a style="text-decoration:none" class="label label-primary  radius"
                                   onClick="managers_show('查看管理员','{{route('admin.managers.show',['managers'=>$val['id']])}}')" href="javascript:;"
                                   >查看</a>
                                <a style="text-decoration:none" class="label label-warning  radius"
                                   onClick="goods_edit('管理员编辑','{{route('admin.managers.edit',['managers'=>$val['id']])}}')" href="javascript:;"
                                   >修改</a>
                                    @if(auth('admin')->id()!=$val['id'])
                                    <a style="text-decoration:none"  class="label label-danger  radius" onClick="managers_del(this,'{{route('admin.managers.destroy',['managers'=>$val['id']])}}')"
                                       href="javascript:;">删除</a>
                                        @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <!--请在下方写此页面业务相关的脚本-->
    <script type="text/javascript" src="/admin/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>

    <script type="text/javascript">





        $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                {"orderable": false, "aTargets": [0, 7]}// 制定列不参与排序
            ]
        });

        /*产品-添加*/
        function goods_add(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        /*产品-查看*/
        function managers_show(title, url) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url,
            });
            layer.full(index);
        }

        /*产品-审核*/
        function goods_shenhe(obj, id) {
            layer.confirm('审核文章？', {
                    btn: ['通过', '不通过'],
                    shade: false
                },
                function () {
                    $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="managers_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布', {icon: 6, time: 1000});
                },
                function () {
                    $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="goods_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                    $(obj).remove();
                    layer.msg('未通过', {icon: 5, time: 1000});
                });
        }

        /*管理员-停用*/
        function managers_stop(obj, url) {

            layer.confirm('确认要停用吗？', function (index) {

                $.ajax({
                    type: 'POST',
                    url: url,
                    data:{_token:$('input[name=_token]').val()},
                    dataType: 'json',
                    success: function (data) {
                        if (data.msg == 'Success') {
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="managers_start(this,id)" href="javascript:;" class="label label-danger radius">启用</a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label  label-danger radius">停用</span>');
                            $(obj).remove();
                            layer.msg('已停用!', {icon: 5, time: 1000});
                        } else {
                            layer.msg(data.msg, {icon: 5, time: 1000});
                        }

                    },
                    error: function (data) {
                        console.log(data.msg);
                    },
                });

            });
        }

        /*管理员-启用*/
        function managers_start(obj, url) {
            layer.confirm('确认要发布吗？', function (index) {

                $.ajax({
                    type: 'POST',
                    url: url,
                    data:{_token:$('input[name=_token]').val()},
                    dataType: 'json',
                    success: function (data) {
                        if (data.msg == 'Success') {
                            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="managers_start(this,id)" href="javascript:;" class="label label-danger radius">停用</a>');
                            $(obj).parents("tr").find(".td-status").html(' <span class="label label-success radius">启用</span>');
                            $(obj).remove();
                            layer.msg('已启用!', {icon: 6, time: 1000});
                        } else {
                            layer.msg(data.msg, {icon: 5, time: 1000});
                        }

                    },
                    error: function (data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*产品-申请上线*/
        function goods_shenqing(obj, id) {
            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
            $(obj).parents("tr").find(".td-manage").html("");
            layer.msg('已提交申请，耐心等待审核!', {icon: 1, time: 2000});
        }

        /*产品-编辑*/
        function goods_edit(title, url,id) {
            var index = layer.open({
                type: 2,
                title: title,
                content: url+'?id='+id,

            });
            layer.full(index);
        }

        /*产品-删除*/
        function managers_del(obj, url) {
            layer.confirm('确认要删除吗？', function (index) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data:{_token:$('input[name=_token]').val()},
                    dataType: 'json',
                    success: function (data) {

                        if (data.msg=='Success'){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!', {icon: 1, time: 1000});
                        }else{
                            layer.msg(data.msg, {icon: 2, time: 2000});
                        }
                    },
                    error: function (data) {
                        console.log(data.msg);
                    },
                });
            });
        }
    </script>

@endsection