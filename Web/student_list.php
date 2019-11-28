<?php//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
require_once("localhost_config.php");
?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="list.css" rel="stylesheet" media="all">
    <title>生徒詳細一覧</title>
</head>

<body>
<!-- ようこそ的なメッセージ 名前抽出わからん-->
<p>ようこそ　ユーザー名さん</p>
<!-- ログアウトボタン 動きはわからん -->
<input id="button" type="submit" value="ログアウト" name="ログアウト"><br>
<H1>生徒一覧</H1><br>
    <?php
//require_once('main_config.php');
require_once('localhost_config.php');
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from teacher';
?>
<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>名前</th>
  <th>クラス</th>
  <th>最終出席時刻</th>
  </tr>

  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['クラス']);?>
    <td><?php print($row['最終出席時刻']);?>
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
<li><a href="teacher_insert.php">生徒登録</li><br>
<!--教員情報変更リンク-->
<li><a href="teacher_update.php">生徒情報変更</li><br>
<!--教員削除リンク-->
<li><a href="teacher_delete.php">生徒削除</li><br>
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