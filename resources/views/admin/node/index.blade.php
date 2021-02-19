@extends('layouts.admin')
@section('title')

@endsection
@section('css')

@endsection
@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span
                class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r"
                                                      style="line-height:1.6em;margin-top:3px"
                                                      href="javascript:location.replace(location.href);" title="刷新"><i
                    class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="text-c">
            <form action="">
                <input type="text" name="node_name" value="{{$params}}"  placeholder=" 请输入权限名称" style="width:250px" class="input-text">
                <button name="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜权限
                </button>
            </form>
        <div class="cl pd-5 bg-1 bk-gray"><span class="l"> <a class="btn btn-primary radius" id="add" href="javascript:;"
                                                                          data-url="{{route('admin.nodes.create')}}"
                                                                          data-type="full"
                                                                          data-title="添加权限"><i class="Hui-iconfont">&#xe600;</i> 添加权限</a> </span> <span
                    class="r">共有数据：<strong>54</strong> 条</span></div>
        <table class="table table-border table-bordered table-hover table-bg">
            <thead>
            <tr>
                <th scope="col" colspan="7">权限管理</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" value="" name=""></th>
                <th width="40">ID</th>
                <th width="200">权限名称</th>
                <th>路由别名</th>
                <th width="300">是否菜单</th>
                <th>矢量图标</th>
                <th width="300">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="" name=""></td>
                    <td>{{$val['id']}}</td>
                    <td class="text-l">{{str_repeat('--',$val['level']*2)}}{{$val['node_name']}}</td>
                    <td>{{$val['route_name']}}</td>
                    <td>{!! $val['menu']!!}</td>
                    <td><i class="Hui-iconfont" style="font-size:18px">{!! str_replace(['-','amp;'],'', $val['icon'])!!}</i></td>
                    <td class="f-14">
                        <a class=" label label-success radius show"  href="javascript:;"
                           data-url="{{route('admin.nodes.show',['nodes'=>$val['id']])}}"
                           data-title="查看权限"
                           {{--data-type="full"--}}
                           style="text-decoration:none">点击查看
                        </a>
                        <a class=" btn btn-warning radius edit"  href="javascript:;"
                           data-url="{{route('admin.nodes.edit',['nodes'=>$val['id']])}}"
                           data-title="修改角色"
                           {{--data-type="full"--}}
                           style="text-decoration:none">修改
                        </a>
                        {{csrf_field()}}
                        <a class=" btn btn-danger radius delete"  href="javascript:;"
                           data-url="{{route('admin.nodes.destroy',['nodes'=>$val['id']])}}"
                           data-title="删除角色"
                           {{--data-type="full"--}}
                           style="text-decoration:none">删除
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('js')
            <script type="text/javascript" src="/js/curd.js"></script>

@endsection