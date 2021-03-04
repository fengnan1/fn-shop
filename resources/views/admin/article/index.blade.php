@extends('layouts.admin')
@section('title')

@endsection
@section('css')

@endsection
@section('content')

    <div class="page-container">
        <form method="get" class="text-c" onsubmit="return dopost()"> 日期范围：
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" name="datemin"
                   id="datemin"
                   class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })"
                   id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入文章标题"
                   value="{{request()->get('search')}}"  id="title" name="title">
            <button type="submit" class="btn btn-success radius"><i class="Hui-iconfont">&#xe665;</i> 搜文章
            </button>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()"
                                                                   class="btn btn-danger radius"><i
                            class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;"
                                                                          onclick=" article_add('添加文章','{{route('admin.articles.create')}}','','510')"
                                                                          class="btn btn-primary radius"><i
                            class="Hui-iconfont">&#xe600;</i> 添加文章</a></span> <span class="r">共有数据：<strong>88</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                    <th width="30">ID</th>
                    <th width="70">文章标题</th>
                    {{--<th width="">文章摘要</th>--}}
                    {{--<th width="">文章内容</th>--}}
                    {{--<th width="150">文章封面</th>--}}
                    {{--<th width="">文章作者</th>--}}
                    {{--<th width="130">文章来源</th>--}}
                    <th width="70">添加时间</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


@endsection
@section('js')
    <script type="text/javascript" src="/js/curd.js"></script>
    <script type="text/javascript">
      var dat= $('.table-sort').dataTable({
            "aaSorting": [[0, "desc"]],//默认第几个排序
            // "bStateSave": true,//状态保存
            "bPaginate": true, //翻页功能
            "bLengthChange": true, //改变每页显示数据数量
            "bFilter": true, //过滤功能
            // "bSort": true, //排序功能
            "bInfo": true,//页脚信息
            // "bAutoWidth": true,//自动宽度
            "oLanguage": {
                "sLengthMenu": "每页显示 _MENU_条",
                // "sZeroRecords": "没有找到符合条件的数据",
                // "sProcessing": "&lt;img src=’./loading.gif’ /&gt;",
                // "sInfo": "当前第 _START_ - _END_ 条　共计 _TOTAL_ 条",
                // "sInfoEmpty": "木有记录",
                // "sInfoFiltered": "(从 _MAX_ 条记录中过滤)",
                "sSearch": "搜索：",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "前一页",
                    "sNext": "后一页",
                    "sLast": "尾页"
                }
            },
            "aoColumnDefs": [
                // {"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {orderable: false, targets: [3]}// 制定列不参与排序
            ],

            //开启本地搜索框
            "searching": false,
            //下拉分页
            lengthMenu: [5, 10, 25, 50, 100],
            {{--//开启服务端分页--}}
            serverSide: true,
            ajax: {
                url: '{{route('admin.articles.index')}}',
                type: 'get',
                {{--//进行post提交时--}}
                        {{--header:{'x-CSRF-TOKEN':'{{csrf_token()}}'},--}}
                data:function (ret) {
                    // console.log(ret)
                //     //封装相应的请求参数，这里获取页大小和当前页码
                //      ret.pagesize = ret.length;//页面显示记录条数，在页面显示每页显示多少项的时候,页大小
                //      ret.start = ret.start;//开始的记录序号
                //     ret.page = (ret.start) / ret.length + 1;//当前页码
                    ret.datemin=$('#datemin').val();
                    ret.datemax=$('#datemax').val();
                    ret.title=$('#title').val();
                }
            },
            columns: [
                //     // {data:'字段名称',defaultContent:'默认值',className:'类名'}
                //     {data:'',defaultContent:'<input type="checkbox" value="1" name="">'},
                {data: 'id', className: 'text-l'},
                {data: 'title',className: 'text-l'},
                {data: 'created_at',className: 'text-l'},
                {data:'action',defaultContent:'默认值',className: 'text-l'}
            ],
            //回调方法
            // 当前行的dom对象
            // 当前行的数据
            // 当前的数据索引
            createdRow:function (row,data,dataIndex) {
                // //当前id
                // var id=data.id;
                // //行的最后一列
                // var td= $(row).find('td:last-child');
                // //显示HTML内容
                // var html='<a href="/admin/articles/'+id+'/edit"  class=" btn btn-secondary  radius ml-5" style="text-decoration:none">修改</a><a title="删除" href="javascript:;" onclick="article_del(this,\''+id+'\')" class=" btn btn-danger  radius ml-5" style="text-decoration:none">\n' +
                //     '删除</a>';
                //
                // td.html(html);

            }
        });


        function dopost() {
            dat.api().ajax.reload();
            return false;

        }

        /*文章-添加*/
        function article_add(title, url, w, h) {
            layer_show(title, url, w, h);
        }

        /*文章-查看*/
        function article_show(title, url, id, w, h) {
            layer_show(title, url, w, h);
        }


        /*文章-编辑*/
        function article_edit(title, url, id, w, h) {
            layer_show(title, url, w, h);
        }


        /*文章-删除*/
        function article_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {

                let url='/admin/article/'+id;
                {{--const _token = "{{csrf_token()}}";--}}
                {{--$.ajax({--}}
                {{--type: 'delete',--}}
                {{--url: '/admin/article/' + id,--}}
                {{--data: {'_token': _token},--}}
                {{--dataType: 'json',--}}
                {{--success: function (data) {--}}
                {{--$(obj).parents("tr").remove();--}}
                {{--layer.msg('已删除!', {icon: 1, time: 1000});--}}
                {{--},--}}
                {{--error: function (data) {--}}
                {{--// console.log(data.msg);--}}
                {{--},--}}
                {{--});--}}
                {{--浏览器自带的--}}
                fetch(url,{
                    method:'delete',
                    headers:{
                        'X-CSRF-TOKEN':'{{csrf_token()}}',
                    },
                }).then(res=>{
                    return res.json();
                }).then(data=>{
                    layer.msg(data.message, {icon: 1, time: 1000},function () {
                        parent.window.location=parent.window.location;
                    });
                })

            });
        }
    </script>

@endsection