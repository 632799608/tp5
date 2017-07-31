layui.use(['form'], function() {
    var form = layui.form(),
        layer = layui.layer,
        $ = layui.jquery;
    $(function(){
        $('.layui-btn-icon').on('click', function() {
          layer.open({
            title:'选择图标',
            type: 2, 
            content: '/admin/permission/icon', //这里content是一个普通的String
            area:['500px','400px']
          });
        });
        //监听提交添加
        form.on('submit(store)', function(data){
            // console.log(data.field);return;
            data.field.is_menu = data.field.is_menu != undefined ? 1 : 0;
            axios.post('/admin/permission/store', data.field).then(function(response) {
                if (response.data.code == 200) {
                    layer.msg(response.data.message,{icon:6}, function() {
                        window.parent.layer.closeAll();
                        window.parent.vn.topList();
                    });
                } else {
                    layer.msg(response.data.message,{icon:6});
                }
            }).catch(function(error) {
                layer.msg('系统错误');
            });
            return false;
        });
        //监听提交编辑
        form.on('submit(update)', function(data){
            console.log(data.field);
            data.field.is_menu = data.field.is_menu != undefined ? 1 : 0;
            axios.post('/admin/permission/update', data.field).then(function(response) {
                if (response.data.code == 200) {
                    layer.msg(response.data.message,{icon:6}, function() {
                        window.parent.layer.closeAll();
                        window.parent.vn.topList();
                    });
                } else {
                    layer.msg(response.data.message,{icon:6});
                }
            }).catch(function(error) {
                layer.msg('系统错误');
            });
            return false;
        });
        form.render();
    });
});
