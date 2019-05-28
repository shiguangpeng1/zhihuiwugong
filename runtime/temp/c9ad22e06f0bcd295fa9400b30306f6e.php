<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:97:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\power\viewJurisdiction.html";i:1558699460;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-配置权限</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
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
            <dd class="layui-this"><a href="<?php echo url('admin/power/administrator'); ?>">角色管理</a></dd>
            <dd><a href="<?php echo url('admin/admin/management'); ?>">角色功能管理</a></dd>
            <dd><a href="<?php echo url('admin/admin/adminLog'); ?>">管理员日志</a></dd>
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
        <li class="layui-nav-item"><a href="<?php echo url('admin/admin/waitMission'); ?>">代办处理事件</a></li>
      </ul>
    </div>
  </div>

  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <div class="breadcrumb">
        <span class="layui-breadcrumb">
          <a href="Administrator.html">管理员管理</a>
          <a href="Administrator.html">角色管理</a>
          <a><cite>查看权限</cite></a>
        </span>
      </div>

      <form class="layui-form" action="##">
        <?php foreach($power as $val): ?>
        <div class="layui-form-item">
          <label class="layui-form-label" data-id="<?php echo $val['power_id']; ?>"><?php echo $val['power_name']; ?></label>
<!--          <?php foreach($data as $vv): ?>-->
<!--          <?php if(in_array($vv['power_id'],$data)): ?>-->
          <div class="layui-input-block">
            <input type="checkbox" checked="<?php echo !empty($val['power_id'])?true:false; ?>" name="admin" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
          </div>
<!--          <?php endif; ?>-->
<!--          <?php endforeach; ?>-->
        </div>
        <?php foreach($val['sub'] as $v): ?>
        <div class="layui-form-item secondary">
          <label class="layui-form-label" data-ids="<?php echo $v['power_id']; ?>"><?php echo $v['power_name']; ?></label>
          <div class="layui-input-block">
            <input type="checkbox" name="role" checked="<?php echo !empty($val['power_id'])?true:false; ?>" lay-skin="switch" lay-filter="switchTest" lay-text="OFF|ON">
          </div>
        </div>
        <?php endforeach; endforeach; ?>
      </form>
    </div>
  </div>

  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script src="/static/resources/layui/layui.js?t=1554901098009"></script>
<script>
  layui.use(['element','form'], function () {
    var $ = layui.$,
            element = layui.element,
            form = layui.form;
    //监听指定开关
    form.on('switch(switchTest)', function(data){
      layer.msg('开关：'+ (this.checked ? 'true' : 'false'), {
        offset: '6px'
      });
    });
    form.on('submit(formDemo)', function(data){
      layer.msg(JSON.stringify(data.field));
      $.ajax({
        url:"<?php echo url('power/add'); ?>",
        type:'post',
        data:data.field,
        success:function(res){
          console.log(res);
          // if (res.status == 1){
          //   window.location="<?php echo url('console/console/index'); ?>";
          // }else{
          //   alert(res.message);
          // }
        }
      });
      return false;
    });
  });
</script>
</body>
</html>
