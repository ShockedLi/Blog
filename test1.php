<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/Blog/lib/Db.php";

$db = new Db();
//$res = $db->table('cates')->field("title")->where(array('title'=>'Web渗透'))->item();
//$res1 = $db->table('cates')->field("*")->where('id > 2')->order('id desc')->limit(5)->lists();
echo '<pre>';
//print_r($res);

// echo '--------------<br>';

// foreach($res1 as $value) {
//     print_r($value);
// }

// 插入
// $data = ['title'=>'逆向'];
// $id = $db->table('cates')->insert($data);
// var_dump($id);

// 删除
// $res = $db->table('cates')->where('id = 14')->delete();
// var_dump($res);

// 更新
$data = ['title'=>'安卓逆向'];
$res = $db->table('cates')->where(array('id'=>12))->update($data);
var_dump($res);
?>