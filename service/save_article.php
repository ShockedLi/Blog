<?php

ini_set("display_errors", "On");//打开错误提示
// ini_set("error_reporting",E_ALL);//显示所有错误
error_reporting(E_ALL);//显示所有错误### 两种写法作用是一样的看个人喜好我一般用下面这种 

session_start();
$user = isset($_SESSION['user'])?$_SESSION['user']:false;
if(!$user) {
    exit(json_encode(array('code'=>1,'msg'=>'您还未登录')));

}


$data['title'] = trim($_POST['title']);
$data['cid'] = (int)$_POST['cid'];
$data['keywords'] = trim($_POST['keywords']);
$data['desc'] = trim($_POST['desc']);
$data['contents'] = htmlspecialchars(trim($_POST['contents']),true);
$data['add_time'] = time();

if(!$data['title']) {
    exit(json_encode(array('code'=>1,'msg'=>'标题不能为空')));
}

require_once $_SERVER['DOCUMENT_ROOT'].'/Blog/lib/Db.php';
$db = new Db();

$id = $db->table('articles')->insert($data);
exit($id);
if(!$id) {
    exit(json_encode(array('code'=>1,'msg'=>'保存失败')));
}
exit(json_encode(array('code'=>0,'msg'=>'保存成功')));

?>