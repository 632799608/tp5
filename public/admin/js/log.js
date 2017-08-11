  layui.use(['element','laypage','layer','form'], function(){
      $ = layui.jquery;//jquery
      lement = layui.element();//面包导航
      laypage = layui.laypage;//分页
      layer = layui.layer;//弹出层
      form = layui.form();//弹出层
      vn = new Vue({
          el: '#app',
          data: {
              log: [],
              pages: 0,
              total: 0,
              search: {
                  pageSize: 15,
              }
          },
          created: function() {
              this.list();
          },
          methods: {
              list: function() {
                  var _this = this;
                  axios.post('/admin/log/index', this.search).then(function(response) {
                      if (_this.pages != response.data.last_page) {
                          _this.$set(_this, 'pages', response.data.last_page);
                          _this.page();
                      }
                      _this.$set(_this, 'log', response.data.data);
                      _this.$set(_this, 'total', response.data.total);
                      _this.$nextTick(function() {
                          form.render();
                      });
                  }).catch(function(error) {
                      console.log(error);
                  });
              },
              // 分页
              page: function() {
                  var _this = this;
                  layui.laypage({
                      cont: 'page',
                      pages: this.pages,
                      skip: true,
                      skin: '#5FB878', //自定义选中色值
                      jump: function(obj, first) {
                          if (!first) {
                              _this.search.page = obj.curr;
                              _this.list();
                          }
                      }
                  });
              },
              changePage: function(pages) {
                  this.$set(this, 'search.pageSize', pages);
                  this.list();
              },
              topList: function() {
                  this.search.pageSize = 15;
                  this.search.page = 1;
                  this.list();
              },
              allDel: function() {
                  var ids = [];
                  var child = $('.layui-table').find('tbody input[type="checkbox"]');
                  child.each(function(index, item) {
                      if (item.checked) {
                        ids.push(parseInt(item.value))
                      }
                  });
                  if (!ids.length) {
                      layer.msg('没有删除的日志');
                      return;
                  };
                  this.elDel(ids);
              },
              elDel: function(id) {
                  var _this = this;
                  layer.confirm('确认删除日志？', function(index) {
                      axios.post('/admin/log/delete',{id:id}).then(function(response) {
                          if (response.data.code == 200) {
                              layer.msg(response.data.message,{icon:6}, function() {
                                  _this.topList();
                              });
                          } else {
                              layer.msg(response.data.message);
                          }
                      }).catch(function(error) {
                          layer.closeAll();
                          layer.msg('系统错误');
                      });
                  })
              }
          }
      });
    //监听提交
    form.on('submit(search)', function(data){
      vn.search.name = data.field.name;
      vn.search.page = 1;
      vn.list();
    });
    //监听复选框
    form.on('checkbox(allChoose)', function(data) {
        var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
        child.each(function(index, item) {
            item.checked = data.elem.checked;
        });
        form.render('checkbox');
    });
  })

