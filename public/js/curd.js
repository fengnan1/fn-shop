$(function(){

    $('.show').click(function(){
        var type = $(this).attr('data-type');
        var title = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        if(type == 'full'){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }else{
            var w = '';
            var h = '360';
            layer_show(title,url,w,h);
        }
    });

    /* 添加*/
    $('#add').click(function(){
        var type = $(this).attr('data-type');
        var title = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        if(type == 'full'){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }else{
            var w = '';
            var h = '360';
            layer_show(title,url,w,h);
        }
    });
    $('.add_child').click(function(){
        var title = '添加下级';
        var url = $(this).attr('data-url');
        var w = '';
        var h = '360';
        layer_show(title,url,w,h);
    });
    /* 修改*/
    $('.edit').click(function(){
        var type = $(this).attr('data-type');
        var title = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        if(type == 'full'){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }else{
            var w = '';
            var h = '360';
            layer_show(title,url,w,h);
        }
    });

    /* 状态修改*/
    $('.edit_status').click(function(){
        var obj = this;
        var status=obj.innerText;
        layer.confirm('确认要'+status+'吗？', function (index) {
            var url = $(obj).attr('data-url');
            $.ajax({
                type: 'PUT',
                url: url,
                data:{_token:$('input[name=_token]').val()},
                dataType: 'json',
                success: function (data) {
                    if (data.msg == 'Success') {
                        // $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="managers_start(this,)" href="javascript:;" class="label label-danger radius">停用</a>');
                        // $(obj).parents("tr").find(".td-status").html(' <span class="label label-success radius">启用</span>');
                        // $(obj).remove();
                        window.location = window.location;
                        layer.msg('已'+status+'!', {icon: 6, time: 1000});
                    } else {
                        layer.msg(data.msg, {icon: 5, time: 1000});
                    }

                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    });
    /* 删除*/
    $('.delete').click(function(){
        var obj = this;
        var type="delete";
        var status=obj.innerText;
        if (status!='删除'){
            type='post'
        }
        layer.confirm('操作须谨慎，确认要'+status+'吗？',function(index){
            var url = $(obj).attr('data-url');
            $.ajax({
                "url":url,
                "type":type,
                "dataType":"json",
                "data":{_token:$('input[name=_token]').val()},
                "success":function(data){
                    if(data.msg == 'Success'){
                        $(obj).closest("tr").remove();
                        window.location = window.location;
                        layer.msg('已'+status+'!',{icon:1,time:1000});
                    }else{
                        layer.msg('删除失败：' + data.msg);
                    }
                }
            });


        });
    });
    /* 批量删除*/
    $('#patch_delete').click(function(){
        var obj = this;
        layer.confirm('删除须谨慎，确认要删除吗？',function(index){
            var url = $(obj).attr('data-url');
            var ids = [];
            $('.row_check:checked').each(function(i,v){
                ids.push($(v).val());
            });
            // var data = {"id":ids.join(',')};

            $.ajax({
                "url":url,
                "type":'delete',
                "data":{ids,_token:$('input[name=_token]').val()},
                "dataType":"json",
                "success":function(data){
                    if(data.msg =='Success' ){
                        $('.row_check:checked').closest('tr').remove();
                        window.location = window.location;
                        layer.msg('已删除!',{icon:1,time:1000});
                    }else{
                        layer.msg('删除失败：' + data.msg);
                    }
                }
            });


        });
    });
});
