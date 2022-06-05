
 <!-- <?php

//PDO方式查询数据库数据

$dsn = 'mysql:host=192.168.0.110; dbname=myblog';
$username = 'root';
$password = 'root';
$pdo = new PDO($dsn, $username, $password);
$pdo->query("set names utf8");

$sql = 'select * from cates where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',5);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($rows);

?>  -->

<!-- <?php

//PDO方式更新数据记录

$dsn = 'mysql:host=192.168.0.110; dbname=myblog';
$username = 'root';
$password = 'root';
$pdo = new PDO($dsn, $username, $password);
$pdo->query("set names utf8");

$sql = 'update cates set title="其他分类_php" where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',10);
$stmt->execute();

echo '<pre>';

?> -->


<?php

//PDO方式插入数据记录

$dsn = 'mysql:host=192.168.0.110; dbname=myblog';
$username = 'root';
$password = 'root';
$pdo = new PDO($dsn, $username, $password);
$pdo->query("set names utf8");

$sql = 'insert into cates(title) values(:title)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title',"Web渗透");
$stmt->execute();

$id = $pdo->lastInsertId();
var_dump($id);
echo '<pre>';


?>