layui.use(['form'], function() {
    var form = layui.form(),
        layer = layui.layer,
        $ = layui.jquery;
    $(function(){
        //自定义验证规则
        form.verify({
            password:[/(.+){6,12}$/, '密码必须6到12位'],
            editassword: function(value){
                if(value != null){
                    if(!(/(.+){6,12}$/.test(value))){ 
                        return '密码必须6到12位'; 
                    } 
                }
            },
            repassword: function(value){
                if($('#password').val()!=$('#repassword').val()){
                    return '两次密码不一致';
                }
            },
            mobile:function (value) {
                if(!(/^1[34578]\d{9}$/.test(value))){ 
                    return '手机号码有误'; 
                } 
            }
        });
        //监听提交添加
        form.on('submit(store)', function(data){
            var roles = '';
            $(":checked").each(function(argument) {
                roles += this.value+',';
            })
            data.field.roles = roles;
            console.log(data.field);
            axios.post('/admin/user/store', data.field).then(function(response) {
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
            var roles = '';
            $(":checked").each(function(argument) {
                roles += this.value+',';
            })
            data.field.roles = roles;
            axios.post('/admin/user/update', data.field).then(function(response) {
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
