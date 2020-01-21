<?php
session_start();
require_once 'server_config.php';
$gobackURL = "teacher_signup.html";
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
$name = $_SESSION['名前'];
$level = $_SESSION['権限'];
}
?>

<!DOCTYPE html>
<script src="jquery-3.4.1.min.js"></script>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="list.css" rel="stylesheet" media="all">
    <title>生徒詳細一覧</title>
</head>
<body>
<!--戻るのリンク-->
<a href="main.php">戻る</a><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>生徒一覧</H1><br>
    <?php
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from student';
?>
<!-- <input id="input1" type="text" value size="100"> -->
<div class='scroll-table'>
<table id="sample1" border="1">
<thead>
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
</thead>
  <?php
  foreach ($dbh->query($sql) as $row) { ?>
    <tbody>
    <tr>
    <!-- <tr  data-href="student_admin.php"> -->
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['学年']);?>
    <td><?php print($row['クラス']);?>
    <td><?php print($row['学科']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['フリガナ']);?>
    <td><?php print($row['メールアドレス']);?>
    <td><?php print($row['電話番号']);?>
    <td><?php print($row['路線1']);?>
    <td><?php print($row['路線2']);?>
    <td><?php print($row['路線3']);?></a>
    </tr>
    </tbody>
      <?php
  }
    ?>
    </table>
    <!-- <script>
    jQuery( function($) {
      $('tbody tr[data-href]').addClass('clickable').click( function() {
        window.location = $(this).attr('data-href');
      }).find('a').hover( function() {
        $(this).parents('tr').unbind('click');
      }, function() {
        $(this).parents('tr').click( function() {
          window.location = $(this).attr('data-href');
        });
      });
    }); -->
<!-- // $("#sample1 td").on("click",function(){
// 	var td_now = $(this).text();
// 	$("#input1").val(td_now);
// }) -->
 <!--/script>　-->
</div>
<div class="float-sample-4">
      <p>　　　　　</p>
</div>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--生徒詳細一覧リンク-->
<li><a href="student_info.php">生徒詳細一覧</a></li><br>
<!--生徒登録リンク-->
<li><a href="student_insert.php">生徒登録</a></li><br>
<!--生徒情報変更リンク-->
<li><a href="student_update.php">生徒情報変更</a></li><br>
<!--生徒削除リンク-->
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