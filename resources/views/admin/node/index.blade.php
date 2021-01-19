@extends('layouts.admin')
@section('title')

@endsection
@section('css')

@endsection
@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span
                class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">

        <div class="cl pd-5 bg-1 bk-gray"><span class="l"> <a href="javascript:;" onclick="datadel()"
                                                              class="btn btn-danger radius"><i
                            class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;"
                                                                          onclick="admin_role_add('添加角色','{{url('admin/role/add')}}','800')"><i
                            class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span
                    class="r">共有数据：<strong>54</strong> 条</span></div>
        <table class="table table-border table-bordered table-hover table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="6">角色管理</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">角色名</th>
                <th>权限id集合</th>
                <th width="300">权限ac集合</th>
                <th width="70">操作</th>
            </tr>
            </thead>
            <tbody>
            {{--@foreach($data as $val)--}}
                {{--<tr class="text-c">--}}
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    {{--<td>{{$val->id}}</td>--}}
                    {{--<td>{{$val->role_name}}</td>--}}
                    {{--<td>@foreach($val->auth as $v) {{$v->auth_name}} @endforeach</td>--}}
                    {{--<td>@foreach($val->auth as $v) {{$v->controller_name}} {{$v->action_name}}@endforeach</td>--}}
                    {{--<td class="f-14">--}}
                        {{--<a title="分派权限" href="javascript:;"--}}
                           {{--onclick="admin_role_assign('分派权限','{{url('admin/role/assign')}}','')"--}}
                           {{--style="text-decoration:none">--}}
                            {{--<i class="Hui-iconfont">&#xe603;</i>--}}
                        {{--</a>--}}
                        {{--<a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','/admin/role/edit','{{$val->id}}')"--}}
                           {{--style="text-decoration:none">--}}
                            {{--<i class="Hui-iconfont">&#xe6df;</i>--}}
                        {{--</a>--}}
                        {{--<a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5"--}}
                           {{--style="text-decoration:none">--}}
                            {{--<i class="Hui-iconfont">&#xe6e2;</i>--}}
                        {{--</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            </tbody>
        </table>
    </div>

@endsection
@section('js')


@endsection