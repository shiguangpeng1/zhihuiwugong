<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:97:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\finance\socialSecurity.html";i:1558750036;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-工资核算提交</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
  <style>
    .layui-table-header .layui-table-cell {
      white-space: normal;
      line-height: 1.5;
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
          <a><cite>社保费用核算</cite></a>
        </span>
      </div>
      <div class="demoTable">
        姓名：
        <div class="layui-inline">
          <input class="layui-input" name="name" id="name" autocomplete="off">
        </div>
        项目点：
        <div class="layui-inline">
          <input class="layui-input" name="site" id="site" autocomplete="off">
        </div>
        日期：
        <div class="layui-inline">
          <input class="layui-input" name="date" id="date" autocomplete="off">
        </div>
        <button class="layui-btn layui-btn-normal layui-icon layui-icon-search" data-type="reload">搜索</button>
        <button class="layui-btn layui-btn-normal iconfont icon-tianjia" data-type="add">添加</button>
      </div>
      <table class="layui-hide" id="mytable" lay-filter="test"></table>
      <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

        </div>
      </script>
      <script type="text/html" id="barDemo">
<!--        <a class="layui-btn layui-btn-primary iconfont icon-shangchuan" style="color: #1BBD9D;" lay-event="del">提交</a>-->
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
      url: "<?php echo url('finance/socialSecurity'); ?>",
      toolbar: '#toolbarDemo',
      title: '用户数据表',
      method:'post',
      parseData: function(res) { //res 即为原始返回的数据
        var data=JSON.parse(res);
        return {
          "code": data.code, //解析接口状态
          // "msg": res.message, //解析提示文本
          "count": data.count, //解析数据长度
          "data": data.data, //解析数据列表
        };
      },
      cols: [[
        {checkbox: true, fixed: true, rowspan: 2},
        {align: 'center', field: 'soc_id', title: 'ID', width: 80, fixed: 'left', sort: true, rowspan: 2},
        {align: 'center', field: 'socialSecurityNumber', title: '社保编号', width: 120, sort: true, rowspan: 2},
        {align: 'center', field: 'name', title: '姓名', width: 120, rowspan: 2},
        {align: 'center', field: 'sex', title: '性别', width: 120, rowspan: 2},
        {align: 'center', field: 'IDNumber', title: '身份证号码', width: 180, rowspan: 2},
        {align: 'center', field: 'censusRegister', title: '户籍性质', width: 180, rowspan: 2},
        {align: 'center', field: 'declare', title: '单位申报职工月平均工资性收入', width: 120, rowspan: 2},
        {align: 'center', field: 'basics', title: '月缴费基数', width: 120, rowspan: 2},
        {align: 'center', title: '个人月缴纳金额明细', colspan: 5},
        {align: 'center', title: '单位月缴纳金额明细', colspan: 7},
        {align: 'center', field: 'total', title: '总计', width: 180, rowspan: 2},
        {align: 'center', field: 'site', title: '项目点', width: 180, rowspan: 2},
        {align: 'center', title: '操作', toolbar: '#barDemo', width: 250, rowspan: 2}
      ],
        [
          {align: 'center', field: 'endowmentInsurance', title: '养老保险（8%）', width: 140,},
          {align: 'center', field: 'medicalInsurance', title: '医疗保险（2%）', width: 140},
          {align: 'center', field: 'unemploymentInsurance', title: '失业保险（0.5%）', width: 150},
          {align: 'center', field: 'largeMedicalInsurance', title: '大额医保', width: 140},
          {align: 'center', field: 'personalTotal', title: '个人缴纳合计', width: 140},
          {align: 'center', field: 'cendowmentInsurance', title: '养老保险（20%）', width: 150},
          {align: 'center', field: 'cmedicalInsurance', title: '医疗保险（9.5%）', width: 150},
          {align: 'center', field: 'cunemploymentInsurance', title: '失业保险（0.5%）', width: 150},
          {align: 'center', field: 'cemploymentInjuryInsurance', title: '工伤保险（0.16%）', width: 160},
          {align: 'center', field: 'cmaternityInsurance', title: '生育保险（1%）', width: 140},
          {align: 'center', field: 'clargeMedicalInsurance', title: '大额医保（1.5%）', width: 150},
          {align: 'center', field: 'companyTotal', title: '单位缴纳合计', width: 140},
        ]],
      id: 'testReload',
      page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
        //,curr: 5 //设定初始在第 5 页
        groups: 1, //只显示 1 个连续页码
        first: false, //不显示首页
        last: false, //不显示尾页

      },
      limit:1,
    });
    var $ = layui.$, active = {
      reload: function () {
        var name = $('#name');
        var site = $('#site');
        var date = $('#date');

        //执行重载
        table.reload('testReload', {
          page: {
            curr: 1 //重新从第 1 页开始
          }
          , where: {
            name: name.val(),
            site: site.val(),
            date: date.val(),
          }
        });
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
  });
</script>
</body>
</html>
