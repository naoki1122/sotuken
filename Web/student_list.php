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
require_once('server_config.php');
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from student';
?>
<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>学年</th>
  <th>クラス</th>
  <th>学科</th>
  <th>名前</th>
  <th>フリガナ</th>
  <th>メールアドレス</th>
  <th>電話番号</th>
  <th>路線１</th>
  <th>路線２</th>
  <th>路線３</th>
  </tr>

  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['学年']);?>
    <td><?php print($row['クラス']);?>
    <td><?php print($row['学科']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['フリガナ']);?>
    <td><?php print($row['メールアドレス']);?>
    <td><?php print($row['電話番号']);?>
    <td><?php print($row['路線１']);?>
    <td><?php print($row['路線２']);?>
    <td><?php print($row['路線３']);?>
    </tr>
      <?php
  }
    ?>
    </table>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--生徒詳細一覧リンク-->
<li><a href="student_info.php">生徒詳細一覧</a></li><br>
<!--生徒登録リンク-->
<li><a href="student_insert.php">生徒登録</a></li><br>
<!--生徒情報変更リンク-->
<li><a href="student_update.php">生徒情報変更</a></li><br>
<!--生徒削除リンク-->
<li><a href="student_delete.php">生徒削除</a></li>
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