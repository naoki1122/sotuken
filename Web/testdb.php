<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>MariaDBへの接続テスト</title>
</head>

<body>
    <?php

$dsn = 'mysql:dbname=management;host=192.168.1.3;charset=utf8';
$user = 'user';
$password = 'marioff3';
try{
  $dbh = new PDO($dsn, $user, $password);

  $sql = 'select * from student';
?>
<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>名前</th>
  <th>ふりがな</th>
  <th>クラス</th>
  <th>メールアドレス</th>
  </tr>

  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['学生番号']);?>
    <td><?php print($row['学科']);?>
    <td><?php print($row['学年']);?>
    <td><?php print($row['クラス']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['フリガナ']);?>
    <td><?php print($row['メールアドレス']);?>
    <td><?php print($row['電話番号']);?>
    <td><?php print($row['パスワード']);?>
    <td><?php print($row['路線１']);?>
    <td><?php print($row['路線２']);?>
    <td><?php print($row['路線３']);?>
    </tr>
      <?php
    }
    ?>
    </table>
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
$dbh = null;
?>
</body>

</html>