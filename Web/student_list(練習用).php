<?php//sotukenサーバー用のDB情報
require_once("server_config.php");
//ローカル用のサーバー情報
//require_once("localhost_config.php");
?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>生徒詳細一覧</title>
</head>

<body>
<!-- ようこそ的なメッセージ 名前抽出わからん-->
<p>ようこそ　ユーザー名さん</p>
<!-- ログアウトボタン 動きはわからん -->
<input id="button" type="submit" value="ログアウト" name="ログアウト"><br>
<H1>生徒一覧</H1><br>
    <?php
require_once('server_config.php');
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from student';
?>
<div class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content float=left">
<table class="table table-striped table-bordered">
<thead class="thead-dark">
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
</div>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--教員登録リンク-->
<li><a href="student_insert.php">生徒登録</a></li><br>
<!--教員情報変更リンク-->
<li><a href="student_update.php">生徒情報変更</a></li><br>
<!--教員削除リンク-->
<li><a href="student_delete.php">生徒削除</a></li><br>
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