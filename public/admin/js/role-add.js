layui.use(['form'], function() {
    var form = layui.form(),
        layer = layui.layer,
        $ = layui.jquery;
    $(function(){
        // 点击一级菜单
        form.on('checkbox(roleOne)',function(data) {
            var el = $(data.elem).parent().next();
            el.find('input').each(function(){ 
                this.checked = data.elem.checked;
            })
            form.render('checkbox');
        })
        // 点击二级菜单
        form.on('checkbox(roleTwo)',function(data) {
            var elc = $(data.elem).parent().next();
            elc.find('input').each(function(){ 
                this.checked = data.elem.checked;
            })
            if (data.elem.checked) {
                var elp = checkParent(data.elem);
                elp.checked = data.elem.checked; 
            }
            form.render('checkbox');
        })
        // 点击三级菜单
        form.on('checkbox(roleThree)',function(data) {
            var elp = checkParent(data.elem);
            var elpp = checkParent(elp);
            if (data.elem.checked) {
                elp.checked = data.elem.checked;
                elpp.checked = data.elem.checked;   
            };
            form.render('checkbox');
        })
        //选择当前权限的父级权限
        function checkParent(el) {
            return $(el).parent().parent().parent().parent().parent().prev().find('input')[0];
        }
        //监听提交添加
        form.on('submit(store)', function(data){
            var rules = '';
            $(":checked").each(function(argument) {
                rules += this.value+',';
            })
            data.field.rules = rules;
            axios.post('/admin/role/store', data.field).then(function(response) {
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
            var rules = '';
            $(":checked").each(function(argument) {
                rules += this.value+',';
            })
            data.field.rules = rules;
            axios.post('/admin/role/update', data.field).then(function(response) {
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
