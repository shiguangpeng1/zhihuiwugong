<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"F:\phpStudy\PHPTutorial\WWW\thinkphp\public/../application/admin\view\login\login.html";i:1558613345;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>智慧务工</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/resources/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/static/resources/css/style.css">
</head>
<body class="login">
<div class="layui-container">
  <div class="login-form">

    <div class="logo-box">
      <div class="logo">
        <img src="" alt="">
      </div>
      <h2 class="title">上海智慧务工</h2>
    </div>
    <form class="layui-form" action="" lay-filter="example">
      <h2 class="login-title">登录</h2>
      <div class="layui-form-item">

        <div class="layui-input-block">
          <input type="text" name="admin" id="username" lay-verify="title" autocomplete="off" placeholder="请输入账号" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">

        <div class="layui-input-block">
          <input type="password" name="pwd" id="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
      </div>


      <div class="layui-form-item">
        <div class="layui-input-block">
          <div class="btn" lay-submit="##" lay-filter="demo1"><span class="layui-icon layui-icon-ok"></span></div>
        </div>
      </div>
    </form>
  </div>

</div>

<script src="/static/resources/layui/layui.js?t=1554901098009"></script>

<script>
  layui.use(['layer','form'],function(){
    var layer=layui.layer,
        form=layui.form;
     var $=layui.$;
   form.on('submit(demo1)', function(data){
    // layer.alert(JSON.stringify(data.field), {
    //
    // })
      $.ajax({
         url:"<?php echo url('login/add'); ?>",
         type:'post',
        dataType:'json',
         data:data.field,
          success:function(res){
           console.log(res);
            if (res.status == 1){
              window.location="<?php echo url('admin/console/index'); ?>";
              // window.location="<?php echo url('admin/index/index'); ?>";
            }else{
              alert(res.message);
            }
          }
     });
    return false;
  });

  })

  // $(document).on('click','.btn',function () {
  //
  //     var username = $('#username').val();
  //     alert(username);
  //     var password = $('#password').val();
  //   alert(password);
  //     $.ajax({
  //       url:"<?php echo url('login/add'); ?>",
  //       type:'post',
  //       data:{username:username,password:password},
  //       dataType:'json',
  //       success:function(res){
  //         console.log(res);
  //       }
  //     })
  // })


</script>
</body>
</html>
