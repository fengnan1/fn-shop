@extends('layouts.admin')
@section('title')
    {{$node['id']?'修改权限':'添加权限'}}
@endsection
@section('css')

@endsection
@section('content')

    <article class="page-container">
        @if($node['id'])
            <form action="{{route('admin.nodes.update',['nodes'=>$node['id']])}}" class="form form-horizontal"
                  @submit.prevent='dopost'>
                {{ method_field('PUT') }}
                {{--{{ method_field('post') }}--}}
                @else
                    <form action="{{route('admin.nodes.store')}}" enctype="multipart/form-data" @submit.prevent='dopost'
                          class="form form-horizontal">
                        {{ method_field('post') }}
                        @endif
                        {{csrf_field()}}
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称:</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" value="{{$node['node_name']}}" v-model.lazy="info.node_name" placeholder=""
                                       name="node_name">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">父级权限：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                 <span class="select-box" style="width:150px;">
                                     <select class="select"   @change="changePid" size="1">
                                        <option value="0">作为顶级权限</option>
                                         @foreach($parents as $val)
                                             {{--{{str_repeat('----',$val->level)}}--}}
                                             <option value="{{$val['id']}}" @if($node['id']&&$node['pid']==$val['id'])selected style="color: red" @endif>{{str_repeat('----',$val['level'])}}{{$val['node_name']}}</option>
                                         @endforeach

                                     </select>
                                 </span>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>作为菜单：</label>
                            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                                @if($node['id'])
                                    @if($node['is_menu']=='是')
                                        <div class="radio-box">
                                            <input name="is_menu" type="radio" value="1" v-model="info.is_menu" checked>
                                            <label for="is_nav-1">是</label>
                                        </div>
                                        <div class="radio-box">
                                            <input type="radio" value="0" name="is_menu" v-model="info.is_menu">
                                            <label for="is_nav-2">否</label>
                                        </div>
                                    @else
                                        <div class="radio-box">
                                            <input name="is_menu" type="radio" v-model="info.is_menu" value="1">
                                            <label for="is_nav-1">是</label>
                                        </div>
                                        <div class="radio-box">
                                            <input type="radio" value="0" name="is_menu" v-model="info.is_menu" checked>
                                            <label for="is_nav-2">否</label>
                                        </div>
                                    @endif
                                @else
                                    <div class="radio-box">
                                        <input name="is_menu" type="radio" value="1" v-model="info.is_menu" checked>
                                        <label for="is_nav-1">是</label>
                                    </div>
                                    <div class="radio-box">
                                        <input type="radio" value="0" name="is_menu" v-model="info.is_menu">
                                        <label for="is_nav-2">否</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">矢量图标：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" placeholder=""  v-model="info.icon" id="icon" name="icon"
                                      >
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">路由别名：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input type="text" class="input-text" v-model="info.route_name" placeholder=""
                                       id="route_name"
                                       name="route_name">
                            </div>
                        </div>

                        <div class="row cl">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                                <input class="btn btn-primary radius" type="submit" value="{{$node['id']?'修改权限':'添加权限'}}">
                            </div>
                        </div>
                    </form>
    </article>

@endsection
@section('js')
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script type="text/javascript" src="/js/vue.js"></script>
    <script type="text/javascript">
        // $('.skin-minimal input').iCheck({
        //     checkboxClass: 'icheckbox-blue',
        //     radioClass: 'iradio-blue',
        //     increaseArea: '20%'
        // });
        var vim=new Vue({
            el:'.page-container',
            data:{
                info:{
                    _token:"{{csrf_token()}}",
                    node_name:"{{$node['id']?$node['node_name']:''}}",
                    pid:"{{$node['id']?$node['pid']:0}}",
                    route_name:"{{$node['id']?$node['route_name']:''}}",
                    icon:"{{$node['id']?str_replace(['-','amp;'],'', $node['icon']):''}}",
                    is_menu:"{{$node['id']?(($node['is_menu']=='是')?'1':'0'):'1'}}",
                }
            },
            methods:{
                // dopost(event){
                //     // console.log(this.info);
                //     console.log(event.target.getAttribute('action'));
                //     let url=event.target.getAttribute('action');
                //
                //     $.post(url,this.info).then(ret=>{
                //         console.log(ret);
                //     })
                // },
               async dopost(event){
                    // console.log(this.info);
                    // console.log(event.target.getAttribute('action'));
                    let url=event.target.getAttribute('action');
                    let method=$('input[name=_method]').val()
                    let ret=await $.ajax({url:url,data:this.info,type:method,dataType:'json'});
                    // let  $.post(url,this.info);
                    // console.log(ret);
                   if (ret.msg == 'Success') {
                   layer.msg('{{$node['id']?'修改权限':'添加权限'}}成功!', {icon: 1, time: 2000}, function () {
                   var index = parent.layer.getFrameIndex(window.name);
                   // parent.$('.btn-refresh').click();
                   parent.window.location = parent.window.location;
                   parent.layer.close(index);
                   });
                   } else {
                   parent.$('.btn-refresh').click();
                   layer.msg(ret.msg, {icon: 2, time: 2000});
                   // layer.msg(data.data, {icon: 2, time: 2000});
                   }
                },
                //下拉列表
                changePid(event){
                    this.info.pid=event.target.value;
                }
            },



        });
        $(function () {
            //初始化默认隐藏
            $('#route_name').parents('.row').hide();

           var va=$('select option:selected').val();
            if (va != 0) {
                $('#route_name').parents('.row').show(300);
                $('#icon').parents('.row').hide();
            } else {
                $('#route_name').parents('.row').hide();
                $('#icon').parents('.row').show(300);
            }
            $('select').change(function () {
                var val = $(this).val();
                // $('#icon,#route_name').val('');
                if (val != 0) {
                    $('#route_name').parents('.row').show(300);
                    $('#icon').parents('.row').hide();
                } else {
                    $('#route_name').parents('.row').hide();
                    $('#icon').parents('.row').show(300);
                }
            })
        });

    </script>

@endsection