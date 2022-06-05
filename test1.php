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

$data = ['title'=>'逆向'];
$id = $db->table('cates')->insert($data);
var_dump($id);

?>