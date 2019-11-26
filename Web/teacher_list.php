<?php//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
require_once("localhost_config.php");
?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="list.css" rel="stylesheet" media="all">
    <title>MariaDBへの接続テスト</title>
</head>

<body>
<!--戻るのリンク-->
<a href="teacher_list.html">戻る</a><br>
<H1>教員一覧</H1><br>
    <?php
//require_once('main_config.php');
require_once('localhost_config.php');
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
 var_dump($dbh);
  $sql = 'select * from teacher';
?>
<div id='style table'>
<table border="1">
  <tr>
  <th>教員番号</th>
  <th>名前</th>
  <th>パスワード</th>
  <th>権限</th>
  </tr>

  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['教員番号']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['パスワード']);?>
    <td><?php print($row['権限']);?>
    </tr>
      <?php
  }
    ?>
    </table>
    <div class="float-sample-4">
      <p>　　　　　</p>
    </div>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--教員登録リンク-->
<li><a href="teacher_insert.php">教員登録</li><br>
<!--教員情報変更リンク-->
<li><a href="teacher_update.php">教員情報変更</li><br>
<!--教員削除リンク-->
<li><a href="teacher_delete.php">教員削除</li><br>
</ul>
    <?php
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
$dbh = null;
?>
<footer>copyright© チームコリジョン</footer>
</body>
</html>