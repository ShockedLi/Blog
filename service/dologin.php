<?php

// 登录验证
$username = $_POST['username'];
$pwd = $_POST['pwd'];
//exit($pwd);
// 验证用户名和密码

require_once "{$_SERVER['DOCUMENT_ROOT']}/Blog/lib/Db.php";
$db = new Db();

$user = $db->table('user')->where(array('username'=>$username))->item();
//exit(var_dump($user));
if(!$user){
	exit(json_encode(array('code'=>1,'msg'=>'该用户不存在')));
}
// 验证密码
//exit(strtoupper(md5($pwd)));
if($user['password'] != strtoupper(md5($pwd))){
	exit(json_encode(array('code'=>1,'msg'=>'密码不正确')));
}

// 保存session
session_start();
$_SESSION['user'] = $user;
exit(json_encode(array('code'=>0,'msg'=>'登录成功')));