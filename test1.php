<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/Blog/lib/Db.php";

$db = new Db();
//$res = $db->table('cates')->field("title")->where(array('title'=>'Web渗透'))->item();
//$res1 = $db->table('cates')->field("*")->where('id > 2')->order('id desc')->limit(5)->lists();
// echo '<pre>';
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
// $data = ['title'=>'安卓逆向'];
// $res = $db->table('cates')->where(array('id'=>12))->update($data);
// var_dump($res);


// 分页查询
$page = $_GET['page'];
$pageSize = 2;
$path = '/Blog/test1.php';
$res = $db->table('cates')->field('id,title')->where('id>1')->page($page,$pageSize,$path);
// print_r($res);

// echo '共查询出'.$res['count'].'记录</br>';
// foreach ($res['data'] as $key => $value) {
//     echo $value['title'].'</br>';
// }

//$num = $db->table('cates')->where('id>1')->count();
//print_r($num);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/plugins/bootstrap/css/bootstrap.min.css">
    <title>分页</title>
</head>
<body>
    <div class="container" style="margin-top: 30px;">
        <p>共查询出<?php echo $res['count']?>记录</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>标题</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($res['data'] as $cates){?>
                <tr>
                    <td><?php echo $cates['id']?></td>
                    <td><?php echo $cates['title']?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <?php
            echo $res['pages'];
        ?>
    </div>
    
</body>
</html>