<?php
session_start();
$gobackURL = "teacher_signup.html";
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  $name = "ゲスト";
  $level = 0;
  // header("Location:{$gobackURL}");
}else{
$name = $_SESSION['名前'];
$level = $_SESSION['権限'];
}

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="list.css" rel="stylesheet" media="all">
    <title>教員詳細一覧</title>
</head>

<body>
<!--戻るのリンク-->
<a href="main.php">戻る</a><br>
<!-- ようこそ的なメッセージ -->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>教員一覧</H1><br>
    <?php
//sotukenサーバー用のDB情報
require_once 'server_config.php';
//ローカル用のサーバー情報
//require_once 'localhost_config.php';


try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from teacher';
?>
<div class='scroll-table'>
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
</div>
    <div class="float-sample-4">
      <p>　　　　　</p>
    </div>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--教員登録リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_insert.php">教員登録</li><br>';
}?>
<!--教員情報変更リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_update.php">教員情報変更</li><br>';
}?>
<!--教員削除リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_delete.php">教員削除</li><br>';
}?>
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