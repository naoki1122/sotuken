<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>MariaDBへの接続テスト</title>
</head>

<body>
    <?php
require_once('server_config.php');
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
 var_dump($dbh);
  $sql = 'select * from student';
?>
<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>学科</th>
  <th>学年</th>
  <th>クラス</th>
  <th>名前</th>
  <th>フリガナ</th>
  <th>メールアドレス</th>
  <th>電話番号</th>
  <th>パスワード</th>
  <th>路線１</th>
  <th>路線２</th>
  <th>路線３</th>
  </tr>

  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
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
    <?php
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
$dbh = null;
?>
</body>

</html>