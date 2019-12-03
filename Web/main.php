<?php
session_start();
require_once 'localhost_config.php';
$gobackURL = "main.html";
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
<!-- ようこそ的なメッセージ 名前抽出わからん-->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン 動きはわからん -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>本日の出席状況</H1><br>
    <?php
//sotukenサーバー用のDB情報
//require_once('main_config.php');
//ローカル用のサーバー情報
require_once 'localhost_config.php';

try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $timestamp = new DataTime();
  $timestamp = $timestamp->format('Y-m-d');
  $sql = 'SELECT student.学籍番号,student.名前,student.クラス,attend.登校時間,attend.登校日,attend.備考 FROM  management.student
          left outer join management.attend
          on student.学籍番号 = attend.学籍番号
          WHERE attend.登校日 like '%11-2%'';
?>

<body>
    <div id='style table'>
        <table border="1">
        <tr>
  <th>学籍番号</th>
  <th>名前</th>
  <th>クラス</th>
  <th>出席状況</th>
  <th>登校時間</th>
  <th>備考</th>
  </tr>
  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['パスワード']);?>
    <td><?php print($row['権限']);?>
    </tr>
      <?php
  }
    ?>
    </table>
</body>
</html>