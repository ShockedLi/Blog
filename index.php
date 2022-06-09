<?php
session_start();
$user = isset($_SESSION['user'])?$_SESSION['user']:false;
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
    <title>欢迎来到我的博客!!!</title>
</head>
<body>
    <div class="header">
        <div class="container">
            <span class="title">ShockedLi的博客</span>
            <div class="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="输入博客标题搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜索</button>
                    </span>
                 </div>
            </div>
          
            <div class="login-reg">
                <?php if($user){?>
                <span><?php echo $user['username']?></span><a href='javascript:;' onclick="logout()">退出</a>
                <?php }else{?>
                <button type="button" class="btn btn-success" onclick="login()">登录</button>
                <?php }?>
                <button type="button" class="btn btn-warning" onclick="add_article()">发表博客</button>
            </div>
        </div>
    </div>
    <div class="main container">
        <div class="col-lg-3 left-container">
            <p class="cates">博客分类</p>
            <div class="cate-list">
                <div class="cate-item"><a href="">编程语言</a></div>
                <div class="cate-item"><a href="">软件设计</a></div>
                <div class="cate-item"><a href="">Web前端</a></div>
                <div class="cate-item"><a href="">企业信息化</a></div>
                <div class="cate-item"><a href="">安卓开发</a></div>
                <div class="cate-item"><a href="">IOS开发</a></div>
                <div class="cate-item"><a href="">软件工程</a></div>
                <div class="cate-item"><a href="">数据库技术</a></div>
                <div class="cate-item"><a href="">操作系统</a></div>
                <div class="cate-item"><a href="">其他分类</a></div>
            </div>
        </div>
        <div class="col-lg-9 right-container">
            <div class="nav">
                <a href="">热门</a>
                <a href="" class="active">最新</a>
            </div>
            <div class="content-list">
                <div class="content-item">
                    <img src="./static/image/avatar.png" alt="">
                    <div class="title">
                        <p><a href="">Web渗透--sql注入</a></p>
                        <div><span>1次浏览</span><span>2022-06-01 12:20:01</span></div>
                    </div>
                </div>
                <div class="content-item">
                    <img src="./static/image/avatar.png" alt="">
                    <div class="title">
                        <p><a href="">Web渗透--xss攻击</a></p>
                        <div><span>1次浏览</span><span>2022-06-01 12:20:01</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    function login(){
        //UI.alert({title:"系统消息", msg:"请输入用户名", icon:"ok"});
        UI.open({title: "登录", url: "./login.php", width: 450,height: 350})
    }

    function logout() {
        if(!confirm('确定要退出吗？')) {
            return;
        }
        $.get('/Blog/service/logout.php',{},function(res){
            if(res.code>0){
				UI.alert({msg:res.msg,icon:'error'});
			}else{
				UI.alert({msg:res.msg,icon:'ok'});
				setTimeout(function(){parent.window.location.reload();},1000);
			}
        },'json');
    }

    function add_article() {
        UI.open({title: "发表博客", url: "./add_article.php", width: 750,height: 650})
    }
</script>