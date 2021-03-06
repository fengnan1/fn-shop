@extends('layouts.admin')
@section('css')
<link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <input type="hidden" id="TenantId" name="TenantId" value=""/>
    <div class="header"></div>
    <div class="loginWraper">
        <div id="loginform" class="loginBox">
            @include('admin.common.validate')
            @include('admin.common.msg')
            <form class="form form-horizontal" action="{{route('admin.login')}}" method="post">
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                    <div class="formControls col-xs-8">
                        <input name="username" type="text" placeholder="账户" value="admin" class="input-text size-L">
                    </div>
                </div>
                {{csrf_field()}}
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                    <div class="formControls col-xs-8">
                        <input name="password" type="password" placeholder="密码" value="123456" class="input-text size-L">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe63f;</i></label>
                    <div class="formControls col-xs-8 ">
                        <input class="input-text size-L" type="text" name="captcha" placeholder="验证码"
                               onblur="if(this.value==''){this.value='验证码:'}"
                               onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
                        <img src="{{captcha_src('mini')}}"  id="captcha"/> <a id="kanbuq" style="font-size: 12px;" href="javascript:;">看不清，换一张</a></div>
                </div>
                {{--<div class="row cl">--}}
                    {{--<div class="formControls col-xs-8 col-xs-offset-3">--}}
                        {{--<label for="online">--}}
                            {{--<input type="checkbox" name="online" id="online" value="">--}}
                            {{--使我保持登录状态</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="row cl">
                    <div class="formControls col-xs-8 col-xs-offset-3">
                        <input name="" type="submit" class="btn btn-success radius size-L"
                               value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                        {{--<input name="" type="reset" class="btn btn-default radius size-L"--}}
                               {{--value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">--}}
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">Copyright 你的公司名称 by H-ui.admin v3.1</div>
@endsection
@section('js')
    <script type="text/javascript">
        var c = document.getElementById('kanbuq');
        var b=document.getElementById('captcha');
        // 对象.onclick = function(){};
        c.onclick = function(){
            // 更新img标签的src属性
            b.src = "{{captcha_src('mini')}}?rand="+Math.random();
        };
                @if(count($errors) > 0)
        var allError='';
        @foreach($errors->all() as $error)
            allError +="{{$error}}<br>";
        @endforeach
        layer.alert(allError,{title:"错误提示",icon:5});

        @endif
    </script>
@endsection
