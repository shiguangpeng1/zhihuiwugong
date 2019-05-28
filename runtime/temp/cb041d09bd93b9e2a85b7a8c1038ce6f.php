<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\personnel\search.html";i:1558929121;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-人员查询</title>
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
        <li class="layui-nav-item layui-nav-itemed">
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
          <a href="javascript:;">人事管理</a>
          <a><cite>人员查询</cite></a>
        </span>
      </div>
      <div class="demoTable">

        <div class="layui-inline">
          <label class="layui-form-label">姓名：</label>
          <div class="layui-input-inline">
            <input class="layui-input" name="name" id="name" autocomplete="off">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">部门：</label>
          <div class="layui-input-inline">
            <input class="layui-input" name="name" id="department" autocomplete="off">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">项目点：</label>
          <div class="layui-input-inline">
            <input class="layui-input" name="site" id="site" autocomplete="off">
          </div>
        </div>
        <div style="margin: 10px 0">
          <div class="layui-inline">
            <label class="layui-form-label">退休年龄：</label>
            <div class="layui-input-inline">
              <input class="layui-input" name="site" id="age" autocomplete="off">
            </div>
          </div>
          <div class="layui-inline">
            <label class="layui-form-label">日期范围</label>
            <div class="layui-input-inline">
              <input type="text" class="layui-input" id="range-picker" placeholder=" - ">
            </div>
          </div>
          <button class="layui-btn layui-btn-normal layui-icon layui-icon-search" data-type="reload">搜索</button>
          <button class="layui-btn layui-btn-danger layui-icon layui-icon-delete" data-type="delCheckData">删除</button>
        </div>


      </div>
      <table class="layui-hide" id="mytable" lay-filter="test"></table>
      <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

        </div>
      </script>
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
  layui.use(['table', 'element', "laydate"], function () {
    var element = layui.element;
    var table = layui.table;
    var laydate = layui.laydate;

    //日期范围
    laydate.render({
      elem: '#range-picker',
      type: 'month',
      range: true
    });
    table.render({
      elem: '#mytable',
      url: "<?php echo url('personnel/search'); ?>",
      toolbar: '#toolbarDemo',
      title: '用户数据表',
      method: 'post',
      parseData: function (res) { //res 即为原始返回的数据
        var data = JSON.parse(res)
        //console.log(data.data)
        return {
          "code": data.code, //解析接口状态
          // "msg": res.message, //解析提示文本
          "count": data.count, //解析数据长度
          "data": data.data, //解析数据列表
        };
      },
      cols: [[
        {checkbox: true, fixed: true, rowspan: 2},
        {align: 'center', field: 'query_id', title: 'ID', width: 80, fixed: 'left', sort: true, rowspan: 2},
        {align: 'center', title: '员工基本信息', colspan: 21},
        {align: 'center', title: '联络方式', colspan: 5},
        {align: 'center', title: '银行卡', colspan: 2},
        {align: 'center', title: '合同必填项', colspan: 5},
        {align: 'center', title: '入职档案', colspan: 16},
        {align: 'center', title: '操作', toolbar: '#barDemo', width: 126, rowspan: 2}
      ],
        [
          //员工基本信息
          {align: 'center', field: 'fn', title: '档案号', width: 120},
          {align: 'center', field: 'site', title: '项目点名称', width: 120},
          {align: 'center', field: 'name', title: '员工姓名', width: 120},
          {align: 'center', field: 'indate', title: '入职日期', width: 120},
          {align: 'center', field: 'livedate', title: '离职日期', width: 120},
          {align: 'center', field: 'salary', title: '基本工资', width: 120},
          {align: 'center', field: 'insurance', title: '保险险种', width: 120},
          {align: 'center', field: 'socialsecuritybegin', title: '社保起缴月份', width: 120},
          {align: 'center', field: 'socialsecuritystop', title: '社保停缴月份', width: 120},
          {align: 'center', field: 'accumulationFundCity', title: '公积金缴纳城市', width: 140},
          {align: 'center', field: 'accumulationFundBegin', title: '公积金起缴月份', width: 140},
          {align: 'center', field: 'accumulationFundStop', title: '公积金停纳缴份', width: 140},
          {align: 'center', field: 'accumulationFundRemarks', title: '社保公积金备注', width: 140},
          {align: 'center', field: 'station', title: '岗位', width: 120},
          {align: 'center', field: 'IDNumber', title: '身份证号码', width: 120},
          {align: 'center', field: 'birthday', title: '出生日期', width: 120},
          {align: 'center', field: 'age', title: '年龄', width: 120},
          {align: 'center', field: 'sex', title: '性别', width: 120},
          {align: 'center', field: 'IDSite', title: '户籍地址', width: 120},
          {align: 'center', field: 'nowSite', title: '现居住地址', width: 120},
          {align: 'center', field: 'workStatus', title: '用工形式', width: 120},
          //联络方式
          {align: 'center', field: 'nowSite2', title: '现住地址', width: 120},
          {align: 'center', field: 'mobile', title: '联系方式', width: 120},
          {align: 'center', field: 'urgency', title: '紧急联系人', width: 120},
          {align: 'center', field: 'urgencyRelation', title: '与紧急联系人的关系', width: 160},
          {align: 'center', field: 'urgencyMobile', title: '紧急联系人电话', width: 140},
          //银行卡
          {align: 'center', field: 'bankName', title: '代发银行', width: 140},
          {align: 'center', field: 'bankNumber', title: '银行卡号', width: 140},
          //合同必填项
          {align: 'center', field: 'contractType', title: '合同类型', width: 140},
          {align: 'center', field: 'contractStatus', title: '是否签订', width: 140},
          {align: 'center', field: 'contractBegin', title: '合同开始时间', width: 140},
          {align: 'center', field: 'contractEnd', title: '合同结束时间', width: 140},
          {align: 'center', field: 'contractRemark', title: '合同备注', width: 140},
          //入职档案
          {align: 'center', field: 'IDCopy', title: '身份证复印件', width: 100},
          {align: 'center', field: 'bankCardCopy', title: '银行卡复印件', width: 100},
          {align: 'center', field: 'staffEntry', title: '员工入职材料清单', width: 100},
          {align: 'center', field: 'confirmation', title: '乙方确认函', width: 100},
          {align: 'center', field: 'social', title: '社保承诺书', width: 100},
          {align: 'center', field: 'haining ', title: '海宁缴保声明', width: 100},
          {align: 'center', field: 'hourly', title: '小时工声明', width: 100},
          {align: 'center', field: 'statement', title: '员工需求表', width: 100},
          {align: 'center', field: 'interview', title: '面试记录表', width: 100},
          {align: 'center', field: 'jobapplication', title: '工作申请表', width: 100},
          {align: 'center', field: 'employee', title: '员工手册B类签收单', width: 100},
          {align: 'center', field: 'employeefiles', title: '员工档案目录', width: 100},
          {align: 'center', field: 'grassroots', title: '基层员工登记表', width: 100},
          {align: 'center', field: 'training', title: '培训反馈表', width: 100},
          {align: 'center', field: 'staff', title: '员工须知', width: 100},
          {align: 'center', field: 'appointment', title: '上岗协议', width: 100},
        ]],

      id: 'testReload',
      page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
        //,curr: 5 //设定初始在第 5 页
        groups: 1, //只显示 1 个连续页码
        first: false, //不显示首页
        last: false, //不显示尾页

      },
      limit: 1,
    });
    var $ = layui.$, active = {
      reload: function () {
        var name = $('#name');
        var site = $('#site');
        var department=$("#department");
        //执行重载
        table.reload('testReload', {
          page: {
            curr: 1 //重新从第 1 页开始
          }
          , where: {
            name: name.val(),
            site:site.val(),
            department: department.val(),
          }
        });
      },
      delCheckData: function () {
        var checkStatus = table.checkStatus('testReload'),
          data = checkStatus.data;
        console.log(data);

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
    //监听行工具事件
    table.on('tool(test)', function (obj) {
      var data = obj.data;
      //console.log(obj)
      if (obj.event === 'del') {
        layer.confirm('确认要删除该条数据吗！', function (index) {
          obj.del();
          layer.close(index);
        });
      } else if (obj.event === 'edit') {

      }
    });
  });
</script>
</body>
</html>
