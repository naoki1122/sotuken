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
$csv;
if($_POST['表示']){
setlocale(LC_ALL, 'ja_JP.UTF-8');

$file = 'csv_inport.csv';
$data = file_get_contents($file);
$data = mb_convert_encoding($data, 'UTF-8', 'auto');
$temp = tmpfile();
$csv  = array();

fwrite($temp, $data);
rewind($temp);

while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
    $csv[] = $data;
}
fclose($temp);

var_dump($csv);
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
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<H1>CSV生徒取り込み</H1><br>
<!--ファイル取り込みボックス（ファイルをCSVに指定）-->
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="filename" accept=".csv">
<input id="button" type="submit" value="表示" name="表示" >
<input id="button" type="submit" value="登録" >
</form><br>
    <?php
try{
  $dbh = new PDO(DSN, DB_USER, DB_PASS);
  $sql = 'select * from student';
?>
<!-- <input id="input1" type="text" value size="100"> -->
<div class='scroll-table-csv'>
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
      echo "<tbody>";
      
  foreach ($csv as $row) { 
    echo "<tr>";
     foreach($row as $v){
      
    echo "<td>${v}</td>";
   }
   echo "</tr>";
  }
  
  echo "</tbody>";
    ?>
    </table>
</div>
<div class="float-sample-4">
      <p>　　　　　</p>
</div>
    <?php
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
$dbh = null;

var_dump($_FILES);
?>
<footer>copyright© チームコリジョン</footer>
</body>
</html>