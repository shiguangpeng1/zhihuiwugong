<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\admin\adminLog.html";i:1558613201;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-管理员日志</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">


  <style>
    #barDemo .layui-btn {
      line-height: 33px;
      border-radius: 8px
    }

    #barDemo .layui-icon:before {
      font-size: 22px;
      position: relative;
      top: 2px;
      margin-right: 5px
    }
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
        <li class="layui-nav-item"><a href="<?php echo url('admin/console/index'); ?>">控制台</a></li>
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">管理员管理</a>
          <dl class="layui-nav-child">
            <dd><a href="<?php echo url('admin/power/administrator'); ?>">角色管理</a></dd>
            <dd><a href="<?php echo url('admin/admin/management'); ?>">角色功能管理</a></dd>
            <dd class="layui-this"><a href="<?php echo url('admin/admin/adminLog'); ?>">管理员日志</a></dd>
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
        <li class="layui-nav-item">
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
          <a href="javascript:;">管理员管理</a>
          <a><cite>管理员日志</cite></a>
        </span>
      </div>
      <div class="demoTable">
        角色名称：
        <div class="layui-inline">
          <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn layui-btn-normal layui-icon layui-icon-search" data-type="reload">搜索</button>
        <button class="layui-btn layui-btn-danger layui-icon layui-icon-delete" data-type="delCheckData">删除</button>
      </div>
      <table class="layui-hide" id="mytable" lay-filter="test"></table>

      <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary layui-icon layui-icon-delete" style="color: #E85141;"
           lay-event="del">删除</a>
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
      method:'post',
      url: "<?php echo url('admin/adminlog'); ?>",
      parseData: function(res) { //res 即为原始返回的数据
        var data=JSON.parse(res)
        return {
          "code": data.code, //解析接口状态
          // "msg": res.message, //解析提示文本
          "count": data.count, //解析数据长度
          "data": data.data, //解析数据列表
        };
      },
      title: '用户数据表',
      cols: [[
        {checkbox: true, fixed: true},
        {field: 're_id', title: 'ID', width: 80, fixed: 'left', sort: true,},
        {field: 'uid', title: '角色名称', width: 120, },
        {field: 'type', title: '操作类别', width: 120},
        {field: 'createt_at', title: '创建时间', width: 160},
        {field: 'ips', title: 'IP', width: 120},
        {title: '操作', toolbar: '#barDemo', width: 150}
      ]],
      id: 'testReload',
      page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
        //,curr: 5 //设定初始在第 5 页
        groups: 5, //只显示 1 个连续页码
        first: false, //不显示首页
        last: false, //不显示尾页

      },
      limit:5,
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
            uid: demoReload.val(),
          }
        });
      },
      delCheckData: function () {
        var checkStatus = table.checkStatus('testReload'),
          data = checkStatus.data;
        //console.log(data[0]);

        if (data.length > 0) {
          var ids = '';
          for (var i = 0; i < data.length; i++) {
            ids += data[i].re_id + ',';
          }
          // console.log(ids);
          layer.confirm('您确认要删除所选条目吗？', function (index) {
            $.ajax({
              url:"<?php echo url('admin/admin/delall'); ?>?re_id="+ids,
              type:'post',
              data:ids,
              success:function(res){
                table.reload('testReload');
                layer.msg('删除成功！', {icon: 1});
              }
            });
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
      var data = obj.data;
      //console.log(obj)
      if (obj.event === 'del') {
        layer.confirm('真的删除行么', function (index) {
          $.ajax({
            url:"<?php echo url('admin/del'); ?>",
            type:'post',
            data:data,
            success:function(res){
              obj.del();
              layer.close(index);
            }
          });
        });
      } else if (obj.event === 'edit') {

      }
    });
  });
</script>
</body>
</html>