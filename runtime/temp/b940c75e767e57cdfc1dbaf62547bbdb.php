<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\power\addadmin.html";i:1558608166;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-添加管理员</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
  <style>
    .layui-form-item{
      margin: 30px 0;
    }
    .layui-form-label{
      font-size: 18px;
      width: 120px;
    }
    .layui-input-block {
      margin-left: 156px;
      min-height: 40px;
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
          <a href="./Administrator.html">角色管理</a>
          <a><cite>添加管理员</cite></a>
        </span>
      </div>
      <div class="layui-row">
        <div class="layui-col-xs9 layui-col-md6 layui-col-md-offset3">
          <form class="layui-form" action="" lay-filter="example">

            <div class="layui-form-item">
              <label for="role_name" class="layui-form-label">角色名称</label>
              <div class="layui-input-block">
                <input type="text" name="role_name" id="role_name" lay-verify="title" autocomplete="off" placeholder="请输入角色名称"
                       class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">账号</label>
              <div class="layui-input-block">
                <input type="text" name="admin" id="username" lay-verify="title" autocomplete="off" placeholder="请输入账号"
                       class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">密码</label>
              <div class="layui-input-block">
                <input type="password" name="pwd" id="password" lay-verify="title" autocomplete="off" placeholder="请输入账号"
                       class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label for="site" class="layui-form-label">管理项目点</label>
              <div class="layui-input-block">
                <select name="pro_id" id="site">
                  <option value="">请选择管理项目点</option>
                  <?php foreach($project as $v): ?>
                  <option value="<?php echo $v['pro_id']; ?>"><?php echo $v['por_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="layui-form-item">
              <div class="layui-input-block">
                <button class="layui-btn layui-btn-fluid layui-btn-normal" lay-submit="##" lay-filter="demo1">确认添加</button>
              </div>
            </div>
          </form>
        </div>
      </div>


    </div>
  </div>

  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © 透视互联 - 2019-05
  </div>
</div>
<script src="/static/resources/layui/layui.js?t=1554901098009"></script>
<script>
  layui.use(['table', 'element'], function () {
    var element = layui.element,
      form = layui.form,
      $ = layui.$;

    form.on('submit(demo1)', function (data) {

      $.ajax({
        url: "<?php echo url('power/addadmin'); ?>",
        type: 'post',
        dataType: 'json',
        data: data.field,
        success: function (res) {

          res =JSON.parse(res);
          //console.log(res);
          if (res.status == 200) {
            window.location = "<?php echo url('admin/power/administrator'); ?>";
          } else {
            alert(res.message);
          }
        }
      });
      return false;
    });
  });
</script>
</body>
</html>
