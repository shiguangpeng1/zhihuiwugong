<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\index\index.html";i:1558934097;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-控制台</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
  <style>
    #pass > div {
      width: 400px;
      height: 300px;
      background-color: #fff;
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
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;" id="changPwd">修改密码</a>
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
      <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed"><a href="<?php echo url('admin/console/index'); ?>">控制台</a></li>
        <li class="layui-nav-item">
          <a class="" href="javascript:;">管理员管理</a>
          <dl class="layui-nav-child">
            <dd><a target="rightContent" href="<?php echo url('admin/power/administrator'); ?>">角色管理</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/admin/management'); ?>">角色功能管理</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/power/siteManagement'); ?>">项目点管理</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/admin/adminLog'); ?>">管理员日志</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">人事管理</a>
          <dl class="layui-nav-child">
            <dd><a target="rightContent" href="<?php echo url('admin/personnel/resumes'); ?>">人员简历管理</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/personnel/personnel'); ?>">人员管理</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/personnel/search'); ?>">人员查询</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">财务管理</a>
          <dl class="layui-nav-child">
            <dd><a target="rightContent" href="<?php echo url('admin/finance/submitSalary'); ?>">工资核算提交</a></dd>
            <dd><a href="<?php echo url('admin/finance/searchSalary'); ?>">薪资查询</a></dd>
            <dd><a href="<?php echo url('admin/finance/socialSecurity'); ?>">社保费用核算</a></dd>
            <dd><a target="rightContent" href="<?php echo url('admin/finance/checkMission'); ?>">单项任务审核</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a target="rightContent" href="<?php echo url('admin/admin/waitMission'); ?>">代办处理事件</a></li>
      </ul>
    </div>
  </div>

  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
      <iframe id='rightContent' name='rightContent' src="<?php echo url('admin/console/index'); ?>" width='100%' height="100%" frameborder="0"></iframe>
    </div>

    <div id="pass" style="display: none">
      <div style="background-color: #fff;padding: 20px 50px">
        <form class="layui-form" action="##" lay-filter="example" style="background-color: #fff">
          <div class="layui-form-item">
            <label class="layui-form-label">旧密码</label>
            <div class="layui-input-block">
              <input type="password" name="password" id="username" lay-verify="title" autocomplete="off"
                     placeholder="请输入账号" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
              <input type="password" name="newpassword" id="password" placeholder="请输入密码" autocomplete="off"
                     class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">确认新密码</label>
            <div class="layui-input-block">
              <input type="password" name="renewpassword" id="password1" placeholder="请输入密码" autocomplete="off"
                     class="layui-input">
            </div>
          </div>

          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit="##" lay-filter="demo2">确认修改</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>

  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>

</div>
<script src="/static/resources/layui/layui.js?t=1554901098009"></script>
<script>
  //JavaScript代码区域
  layui.use(['element', 'layer', 'form'], function () {
    var element = layui.element,
      form = layui.form,
      $ = layui.$;
    $("#changPwd").on("click", function () {
      layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        area: '516px',
        skin: 'layui-layer-nobg', //没有背景色
        shadeClose: true,
        content: $("#pass").html()
      });

    });
    form.on('submit(demo2)', function (data) {

      $.ajax({
        url: "<?php echo url('login/changepassword'); ?>",
        type: 'post',
        dataType: 'json',
        data: data.field,
        success: function (res) {
          //console.log(res.msg);
          if (res.code == 200) {
            window.location = "<?php echo url('admin/login/index'); ?>";
          } else {
            alert(res.msg);
          }
        }
      })
      return false;
    });
  });
</script>
</body>
</html>
