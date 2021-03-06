<?php
session_start();
require_once 'server_config.php';
require_once 'lib.php';
$gobackURL = "teacher_signup.html";

if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
$name = $_SESSION['名前'];
$level = $_SESSION['権限'];
}
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="info.css" rel="stylesheet" media="all">
    <title>生徒詳細情報</title>
</head>

<body>
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<h1>生徒詳細情報</h1>
    <?php

try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $word="";
  if(isset($_POST['検索'])){
    if(isset($_POST['word'])){
    $word = $_POST['word'];
    $_SESSION['word'] = $word;
    }else{
    $word="";
  }
}
  $sql = 'select 登校日,登校時間 from management.attend where 学籍番号 = :word';
  $stmt = $pdo->prepare($sql);
  $stmt->bindvalue(':word', $word,PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
<!--検索条件入力-->
<input id="input1" type="text" name="word" autofocus autocomplete="off" required placeholder="学籍番号を入力">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form>
<p></p><br>
<!--テーブル云々　抽出とかわからん-->
<div class='scroll-table'>
<table border="1" align="center">
  <tr>
  <th>日付</th>
  <th>出席時刻</th>
  </tr>

  <?php
  foreach ($result as $row) { ?>
    <tr>
    <td><?php print($row['登校日']);?>
    <td><?php print($row['登校時間']);?>
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
<ul style="list-style: disc">
<!--出席情報変更リンク-->
<li><a href="student_info_update.php">出席情報変更</a></li><br>
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