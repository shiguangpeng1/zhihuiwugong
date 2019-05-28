<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\finance\checkMission.html";i:1558679102;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-单项任务审核</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
  <style>

  </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header layui-bg-blue">
    <div class="layui-logo">上海智慧务工</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">修改密码</a>
      </li>
      <li class="layui-nav-item"><a href="<?php echo url('admin/login/out'); ?>">退出</a></li>
    </ul>
  </div>

  <div class="layui-side layui-bg-black left-side">
    <div class="layui-side-scroll">
      <div class="layui-row user">
        <div class="layui-col-xs4">
          <img class="avator" src="http://t.cn/RCzsdCq">
        </div>
        <div class="layui-col-xs8">
          <div class="info"><?php echo $user['admin']?></div>
          <div class="info"><?=$user['status']==1 ? '超级管理员':'普通用户'?></div>
        </div>
      </div>
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree">
        <li class="layui-nav-item layui-nav-itemed"><a href="<?php echo url('admin/console/index'); ?>">控制台</a></li>
        <li class="layui-nav-item">
          <a class="" href="javascript:;">管理员管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/power/administrator'); ?>">角色管理</a></dd>
            <dd><a href="<?php echo url('admin/admin/management'); ?>">角色功能管理</a></dd>
            <dd><a href="<?php echo url('admin/admin/adminLog'); ?>">管理员日志</a></dd>
            <dd><a href="<?php echo url('admin/admin/setmanagement'); ?>">项目点管理</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">人事管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/personnel/resumes'); ?>">人员简历管理</a></dd>
            <dd><a href="<?php echo url('admin/personnel/personnel'); ?>">人员管理</a></dd>
            <dd><a href="<?php echo url('admin/personnel/search'); ?>">人员查询</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item layui-nav-itemed">
          <a href="javascript:;">财务管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/finance/submitSalary'); ?>">工资核算提交</a></dd>
            <dd><a href="<?php echo url('admin/finance/searchSalary'); ?>">薪资查询</a></dd>
            <dd><a href="<?php echo url('admin/finance/socialSecurity'); ?>">社保费用核算</a></dd>
            <dd><a href="<?php echo url('admin/finance/checkMission'); ?>">单项任务审核</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="<?php echo url('admin/admin/waitMission'); ?>">待办处理事件</a></li>
      </ul>
    </div>
  </div>

  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <div class="breadcrumb">
        <span class="layui-breadcrumb">
          <a href="javascript:;">财务管理</a>
          <a><cite>单项任务审核</cite></a>
        </span>
      </div>
      <div class="demoTable">
        搜索ID：
        <div class="layui-inline">
          <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn layui-btn-normal layui-icon layui-icon-search" data-type="reload">搜索</button>
        <button class="layui-btn layui-btn-danger layui-icon layui-icon-delete" data-type="delCheckData">删除</button>
      </div>
      <table class="layui-hide" id="mytable" lay-filter="test"></table>
      <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

        </div>
      </script>
      <script type="text/html" id="barDemo">

        <a class="layui-btn layui-btn-primary iconfont icon-tongyi" style="color: #1BBD9D;"
           lay-event="agree">同意</a>
        <a class="layui-btn layui-btn-primary iconfont icon-guanbi" style="color: #E85141;"
           lay-event="reject">拒绝</a>
      </script>

    </div>
  </div>

  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script src="/static/resources/layui/layui.js?t=1554901098009"></script>
<script>
  layui.use(['table', 'element'], function () {
    var element = layui.element;
    var table = layui.table;
    table.render({
      elem: '#mytable',
      url: "<?php echo url('finance/checkMission'); ?>",
      toolbar: '#toolbarDemo',
      title: '用户数据表',
      method:'post',
      parseData: function(res) { //res 即为原始返回的数据
        var data=JSON.parse(res);
        //console.log(data.data)
        return {
          "code": data.code, //解析接口状态
          // "msg": res.message, //解析提示文本
          "count": data.count, //解析数据长度
          "data": data.data, //解析数据列表
        };
      },
      cols: [[
        {align: 'center',field: 'name', title: '姓名', width: 100},
        {align: 'center',field: 'time', title: '申请日期', templet:function(obj){
           var date=obj.time;
              function add0(m){return m<10?'0'+m:m }
              let time = new Date(date*1000);
              let y = time.getFullYear();
              let m = time.getMonth()+1;
              let d = time.getDate();
              return y+'年'+add0(m)+'月'+add0(d)+'日';
          },width: 140},
        {align: 'center',field: 'type', title: '申请类别', width: 120},
        {align: 'center',field: 'money', title: '申请金额', width: 120},
        {align: 'center',field: 'status', title: '任务状态', templet: function(obj){
          var str= '';
          var status=obj.status;
             if(status==0){
               str='未开始'
             }else if(status==1){
               str='完成'
             }
        return str
    }, width: 120},
        {align: 'center',field: 'result', title: '结果',templet: function(obj){
            var str= '';
            var result=obj.result;
            if(result==0){
              str='未操作'
            }else if(result==1){
              str='同意'
            }else{
              str='拒绝'
            }
            return str
          }, width: 120},
        {align: 'center',title: '操作', toolbar: '#barDemo', width: 235}
      ]],
      id: 'testReload',
      page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
        //,curr: 5 //设定初始在第 5 页
        groups: 1, //只显示 1 个连续页码
        first: false, //不显示首页
        last: false, //不显示尾页

      }
    });
    var $ = layui.$, active = {
      reload: function () {
        var demoReload = $('#demoReload');

        //执行重载
        table.reload('testReload', {
          page: {
            curr: 1 //重新从第 1 页开始
          }
          , where: {
            key: demoReload.val(),
          }
        });
      },
      delCheckData: function () {
        var checkStatus = table.checkStatus('testReload'),
          data = checkStatus.data;

        if (data.length > 0) {
          var ids = '';
          for (var i = 0; i < data.length; i++) {
            ids += data[i].id + ',';
          }
          layer.confirm('您确认要删除所选条目吗？', function (index) {
            $(".layui-form-checked").not('.header').parents('tr').remove();
            layer.msg('删除成功！', {icon: 1});
          })
        } else {
          layer.msg('请选择要删除的条目！', {icon: 2});
        }
      }
    };

    $('.demoTable').on('click', '.layui-btn', function () {
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });
    //监听单元格编辑
    table.on('edit(test)', function (obj) {
      var value = obj.value, //得到修改后的值
        data = obj.data, //得到所在行所有键值
        field = obj.field; //得到字段
      layer.msg('[ID: ' + data.id + '] ' + field + ' 字段更改为：' + value);
    });
    //监听行工具事件
    table.on('tool(test)', function (obj) {

      //var id = obj.data.id;

      var status =obj.data.status;
      //console.log(status);
      var result =obj.data.result;

      var time =obj.data.time;

      var examine_id =obj.data.examine_id;
      if (obj.event === 'agree') {
        if(result==0){
          layer.confirm('确定同意该申请吗?', function (index) {
            $.ajax({
              url:"<?php echo url('finance/change'); ?>",
              type: 'post',
              dataType: 'json',
              data: {status:'1',time:time,examine_id:examine_id,result:result},
              success: function (res) {

                table.reload('testReload');
              }
            });
            layer.close(index);
          });
        }else{
          layer.msg('您已经操作过了，请不要重复操作！', {icon: 2});
        }

      } else if (obj.event === 'reject') {
        if(result==0){
          layer.confirm('确定拒绝该申请吗?', function (index) {
            $.ajax({
              url:"<?php echo url('finance/reject'); ?>",
              type: 'post',
              dataType: 'json',
              data: {status:'-2',time:time,examine_id:examine_id,result:result},
              success: function (res) {
                table.reload('testReload');
              }
            });
            layer.close(index);
          });
        }else{
          layer.msg('您已经操作过了，请不要重复操作！', {icon: 2});
        }


      }
    });
  });
</script>
</body>
</html>
