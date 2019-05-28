<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\personnel\personnel.html";i:1558924661;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>上海智慧务工-简历管理</title>
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
  <style>
    .layui-table-header .layui-table-cell{
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
          <a><cite>人员管理</cite></a>
        </span>
      </div>
      <div class="demoTable">
        <div style="margin-bottom: 10px">

          员工姓名：
          <div class="layui-inline">
            <input class="layui-input" name="name" id="name" autocomplete="off">
          </div>
          身份证号码：
          <div class="layui-inline">
            <input class="layui-input" name="idnumber" id="idnumber" autocomplete="off">
          </div>
          日期：
          <div class="layui-inline">
            <input class="layui-input" name="date" id="date" autocomplete="off">
          </div>
          <button class="layui-btn layui-btn-normal layui-icon layui-icon-search" data-type="search">搜索</button>
        </div>
        <button id="upLoadFile" class="layui-btn layui-btn-normal iconfont icon-tianjia">批量导入</button>
<!--        <button class="layui-btn layui-btn-normal iconfont icon-tianjia" data-type="downLoad">批量导出</button>-->
        <a class="layui-btn layui-btn-normal iconfont icon-tianjia" href="<?php echo url('personnel/export'); ?>" data-type="downLoad">批量导出</a>

        <button class="layui-btn layui-btn-normal iconfont icon-tianjia"  data-type="add">添加</button>
      </div>
      <table class="layui-hide" id="mytable" lay-filter="test"></table>
      <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

        </div>
      </script>
      <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-primary iconfont icon-shangchuan" style="color: #236CFF;" lay-event="submit">提交</a>
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
  layui.use(['table', 'element','upload'], function () {
    var element = layui.element;
    var table = layui.table;
    var upload=layui.upload;
    upload.render({ //允许上传的文件后缀
      elem: '#upLoadFile',
      url: "<?php echo url('personnel/add'); ?>",
      accept: 'file', //excel文件
      exts: 'xls', //只允许上传压缩文件
      done: function(res){
      table.reload('testReload');
      }
    });
    table.render({
      elem: '#mytable',
      url: "<?php echo url('personnel/personnel'); ?>",
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
        {checkbox: true, fixed: true,rowspan:2},
        {align: 'center',field: 'query_id', title: 'ID', width: 80, fixed: 'left', sort: true,rowspan:2},
        {align: 'center', title: '员工基本信息', colspan: 21},
        {align: 'center', title: '联络方式', colspan: 5},
        {align: 'center', title: '银行卡', colspan: 2},
        {align: 'center', title: '合同必填项', colspan: 5},
        {align: 'center', title: '入职档案', colspan: 16},
        {align: 'center',title: '操作', toolbar: '#barDemo', width: 126,rowspan:2}
      ],
        [
          //员工基本信息
          {align: 'center',field: 'fn', title: '档案号', width: 120,edit:true},
          {align: 'center',field: 'site', title: '项目点名称', width: 120,edit:true},
          {align: 'center',field: 'name', title: '员工姓名', width: 120,edit:true},
          {align: 'center',field: 'indate', title: '入职日期', width: 120,edit:true},
          {align: 'center',field: 'livedate', title: '离职日期', width: 120,edit:true},
          {align: 'center',field: 'salary', title: '基本工资', width: 120,edit:true},
          {align: 'center',field: 'insurance', title: '保险险种', width: 120,edit:true},
          {align: 'center',field: 'socialsecuritybegin', title: '社保起缴月份', width: 120,edit:true},
          {align: 'center',field: 'socialsecuritystop', title: '社保停缴月份', width: 120,edit:true},
          {align: 'center',field: 'accumulationfundcity', title: '公积金缴纳城市', width: 140,edit:true},
          {align: 'center',field: 'accumulationfundbegin', title: '公积金起缴月份', width: 140,edit:true},
          {align: 'center',field: 'accumulationfundstop', title: '公积金停纳缴份', width: 140,edit:true},
          {align: 'center',field: 'accumulationfundremarks', title: '社保公积金备注', width: 140,edit:true},
          {align: 'center',field: 'station', title: '岗位', width: 120,edit:true},
          {align: 'center',field: 'idnumber', title: '身份证号码', width: 120,edit:true},
          {align: 'center',field: 'birthday', title: '出生日期', width: 120,edit:true},
          {align: 'center',field: 'age', title: '年龄', width: 120,edit:true},
          {align: 'center',field: 'sex', title: '性别', width: 120,edit:true},
          {align: 'center',field: 'issite', title: '户籍地址', width: 120,edit:true},
          {align: 'center',field: 'nowsite', title: '现居住地址', width: 120,edit:true},
          {align: 'center',field: 'workstatus', title: '用工形式', width: 120,edit:true},
          //联络方式
          {align: 'center',field: 'nowsitex', title: '现住地址', width: 120,edit:true},
          {align: 'center',field: 'mobile', title: '联系方式', width: 120,edit:true},
          {align: 'center',field: 'urgency', title: '紧急联系人', width: 120,edit:true},
          {align: 'center',field: 'urgencyrelation', title: '与紧急联系人的关系', width: 160,edit:true},
          {align: 'center',field: 'urgencymobile', title: '紧急联系人电话', width: 140,edit:true},
          //银行卡
          {align: 'center',field: 'bankname', title: '代发银行', width: 140,edit:true},
          {align: 'center',field: 'banknumber', title: '银行卡号', width: 140,edit:true},
          //合同必填项
          {align: 'center',field: 'contracttype', title: '合同类型', width: 140,edit:true},
          {align: 'center',field: 'contractstatus', title: '是否签订', width: 140,edit:true},
          {align: 'center',field: 'contractbegin', title: '合同开始时间', width: 140,edit:true},
          {align: 'center',field: 'contractend', title: '合同结束时间', width: 140,edit:true},
          {align: 'center',field: 'contractremark', title: '合同备注', width: 140,edit:true},
          //入职档案
          {align: 'center',field: 'idcopy', title: '身份证复印件', width: 100,edit:true},
          {align: 'center',field: 'bankcardcopy', title: '银行卡复印件', width: 100,edit:true},
          {align: 'center',field: 'staffentry', title: '员工入职材料清单', width: 100,edit:true},
          {align: 'center',field: 'confirmation', title: '乙方确认函', width: 100,edit:true},
          {align: 'center',field: 'social', title: '社保承诺书', width: 100,edit:true},
          {align: 'center',field: 'haining', title: '海宁缴保声明', width: 100,edit:true},
          {align: 'center',field: 'hourlyworke', title: '小时工声明', width: 100,edit:true},
          {align: 'center',field: 'statement', title: '员工需求表', width: 100,edit:true},
          {align: 'center',field: 'interview ', title: '面试记录表', width: 100,edit:true},
          {align: 'center',field: 'job', title: '工作申请表', width: 100,edit:true},
          {align: 'center',field: 'employee', title: '员工手册B类签收单', width: 100,edit:true},
          {align: 'center',field: 'directory', title: '员工档案目录', width: 100,edit:true},
          {align: 'center',field: 'registration', title: '基层员工登记表', width: 100,edit:true},
          {align: 'center',field: 'training', title: '培训反馈表', width: 100,edit:true},
          {align: 'center',field: 'instructions', title: '员工须知', width: 100,edit:true},
          {align: 'center',field: 'agreement', title: '上岗协议', width: 100,edit:true},
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
      //搜索
      search: function () {
        var name = $('#name');
        var idnumber = $('#idnumber');
        var date = $('#date');

        //执行重载
        table.reload('testReload', {
          page: {
            curr: 1 //重新从第 1 页开始
          }
          , where: {
            name: name.val(),
            idnumber: idnumber.val(),
            date: date.val(),
          }
        });
      },
      // downLoad: function () {
      //   $.ajax({
      //     url:"<?php echo url('personnel/export'); ?>",
      //     type:'post',
      //     success:function(res){
      //       console.log(res)
      //     }
      //
      //   });
      //
      // },
      //添加
      add:function(obj){
        var data=table.cache.testReload;

        table.reload('testReload',{
          parseData: function(res) { //res 即为原始返回的数据
            var data=JSON.parse(res);
            var arr=data.data;
            arr.unshift({});
            return {
              "code": data.code, //解析接口状态
              // "msg": res.message, //解析提示文本
              "count": data.count, //解析数据长度
              "data": arr, //解析数据列表
            };
          },
        })
      },
    };

    $('.demoTable').on('click', '.layui-btn', function () {
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });

    //监听行工具事件
    table.on('tool(test)', function (obj) {
      var data = obj.data;
      // console.log(obj);
      if (obj.event === 'submit') {
        layer.confirm('你确定要提交该条信息吗？', function (index) {
          $.ajax({
            url:"<?php echo url('personnel/dell'); ?>",
            type:'post',
            dataType:'json',
            data:data,
            success:function(res){

              res = JSON.parse(res);
              // console.log(res);
              table.reload('testReload');
              if (res.status==1){
                table.reload('testReload');

              } else{
                alert(res.message);
              }
            }

          });
          layer.close(index);
        });
      }
    });
  });
</script>
</body>
</html>
