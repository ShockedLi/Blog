<?php
session_start();
$user = $_SESSION['user'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./static/js/jquery.min.js"></script>
    <link rel="stylesheet" href="./static/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/css/site.css">
    <script src="./static/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="./static/js/UI.js"></script>
    <title>登录</title>
    <style>
        .title {
            text-align: center;
            font-size: 18px;
            color: #666;
        }
        .form {
            margin-top: 50px;
            padding: 0px 80px;
        }
        .form .input-group {
            margin: 10px 0px;
        }
    </style>
</head>
<body>
    <div class='title'>登录博客</div>
    <div class='form'>
        <div class="input-group input-group-sm">
            <span class="input-group-addon" >账&nbsp;&nbsp;&nbsp;号</span>
            <input type="text" class="form-control" name="username" placeholder="username" >
        </div>
        <div class="input-group input-group-sm">
            <span class="input-group-addon" >密&nbsp;&nbsp;&nbsp;码</span>
            <input type="password" class="form-control" name="pwd" placeholder="password" >
        </div>
        <button type="button" class="btn btn-primary btn-sm btn-block" onclick = 'login()'>登录</button>
    </div>
    
</body>
</html>

<script type="text/javascript">
	// 登录
	function login(){
		var username = $.trim($('input[name="username"]').val());
		var pwd = $.trim($('input[name="pwd"]').val());
		if(username == ''){
            //UI.alert({title:"系统消息", msg:"请输入用户名", icon:"ok"});
			UI.alert({msg:'用户名不能为空',icon:'error'});
			return;
		}
		if(pwd == ''){
			UI.alert({msg:'密码不能为空',icon:'error'});
			return;
		}
		// 提交验证
		$.post('/Blog/service/dologin.php',{username:username,pwd:pwd},function(res){
			if(res.code>0){
				UI.alert({msg:res.msg,icon:'error'});
			}else{
				UI.alert({msg:res.msg,icon:'ok'});
				setTimeout(function(){parent.window.location.reload();},1000);
			}
		},'json');

	}
</script>