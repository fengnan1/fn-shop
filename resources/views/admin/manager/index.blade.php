@extends('layouts.admin')
@section('title')
    管理员列表
@endsection
@section('css')
    <link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
@endsection
@section('content')
    <div>
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
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜管理员
                </button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" class="btn btn-danger radius"
                                                                       data-url="{{route('admin.managers.patch_delete')}}"
                                                                       data-title="批量删除管理员"
                                                                       id="patch_delete"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                    <a
                            class="btn btn-primary radius"
                            data-url="{{route('admin.managers.create')}}"
                            data-title="添加管理员"
                            data-type="full"
                            id="add" href="javascript:;"><i
                                class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span
                        class="r">共有数据：<strong>54</strong> 条</span></div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-hover table-sort">
                    <thead>
                    <tr class="text-c">
                        <th width="3%"><input type="checkbox" name="id[]" value=""></th>
                        <th width="4%">ID</th>
                        <th width="6%">用户名</th>
                        <th width="7%">真实姓名</th>
                        <th width="7%">角色名称</th>
                        <th width="5%">性别</th>
                        <th width="8%">手机号</th>
                        <th width="15%">邮箱</th>
                        <th width="8%">邮箱是否验证</th>
                        <th width="5%">排序</th>
                        <th>创建时间</th>
                        <th width="6%">账号状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $val)
                        <tr class="text-c va-m">
                            <td>
                                @if(auth('admin')->id()!=$val['id']&&$val['deleted_at']==null)
                                    <input class="row_check" name="id" type="checkbox" value="{{$val['id']}}">
                                @endif

                            </td>
                            <td>{{$val['id']}}</td>
                            <td class="text-l">{{$val['username']}}</td>
                            <td class="text-l">{{$val['truename']}}</td>
                            <td class="text-l">{{$val->role->role_name}}</td>
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

                                @if(auth('admin')->id()!=$val['id'])
                                    @if($val['deleted_at']!=null)
                                        <a style="text-decoration:none" class="label label-secondary  radius delete"
                                           data-url="{{route('admin.managers.restores',['managers'=>$val['id']])}}"
                                           href="javascript:;">恢复</a>
                                    @else
                                        @if($val['status']=='1')
                                            <a style="text-decoration:none"
                                               data-url="{{route('admin.managers.edit_status',['managers'=>$val['id']])}}"
                                               href="javascript:;" class="label label-danger radius edit_status">停用</a>
                                        @else
                                            <a style="text-decoration:none"
                                               data-url="{{route('admin.managers.edit_status',['managers'=>$val['id']])}}"
                                               href="javascript:;"
                                               class="label label-success radius  edit_status">启用</a>
                                        @endif
                                        <a style="text-decoration:none" class="label label-primary  radius show"
                                           data-url="{{route('admin.managers.show',['managers'=>$val['id']])}}"
                                           data-title="分配角色"
                                           {{--data-type="full"--}}
                                           href="javascript:;"
                                        >分配角色</a>
                                        <a style="text-decoration:none" class="label label-warning  radius edit"
                                           data-url="{{route('admin.managers.edit',['managers'=>$val['id']])}}"
                                           data-title="修改管理员"
                                           {{--data-type="full"--}}
                                           href="javascript:;"
                                        >修改</a>
                                        <a style="text-decoration:none" class="label label-danger  radius delete"
                                           data-url="{{route('admin.managers.destroy',['managers'=>$val['id']])}}"
                                           href="javascript:;">删除</a>
                                    @endif
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
    <script type="text/javascript" src="/js/curd.js"></script>
    <script type="text/javascript">

        window.onload = $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                {"orderable": false, "aTargets": [0, 7]}// 制定列不参与排序
            ]
        });
    </script>

@endsection