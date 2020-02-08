<?php
session_start();
require_once 'server_config.php';
require_once "lib.php";

$gobackURL = "teacher_signup.html";
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
}

if(isset($_POST['NAME_UP']))$name_up = $_POST['NAME_UP'];
if(isset($_POST['NAME_DOWN']))$name_down = $_POST['NAME_DOWN'];
if(isset($_POST['HURI']))$huri = $_POST['HURI'];
if(isset($_POST['S_NO']))$s_no = $_POST['S_NO'];
if(isset($_POST['PASSWD']))$pass = $_POST['PASSWD'];
if(isset($_POST['YEAR']))$year = $_POST['YEAR'];
if(isset($_POST['CLASS']))$class = $_POST['CLASS'];
if(isset($_POST['SUBJECT']))$subject = $_POST['SUBJECT'];
if(isset($_POST['MAIL']))$mail = $_POST['MAIL'];
if(isset($_POST['TEL']))$tel = $_POST['TEL'];
if(isset($_POST['TRAIN1']))$train1 = $_POST['TRAIN1'];
if(isset($_POST['TRAIN2']))$train2 = $_POST['TRAIN2'];
if(isset($_POST['TRAIN3']))$train3 = $_POST['TRAIN3'];

if(isset($_POST['表示'])){
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

}

if(isset($_POST['登録'])){
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

  $tbl ="management.student";
  $pdo = dbcon();
  $sql = "INSERT INTO ${tbl}(学籍番号,学年,クラス,学科,名前,フリガナ,メールアドレス,電話番号,路線1,路線2,路線3)
          VALUES (:s_no,:year,:class,:subject,:name,:huri,:mail,:tel,:train1,:train2,:train3)";
  $stmt = $pdo->prepare($sql);
  if(!empty($s_no))$stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
  if(!empty($year))$stmt->bindValue(":year", $year, PDO::PARAM_INT);
  if(!empty($class))$stmt->bindValue(":class", $class, PDO::PARAM_INT);
  if(!empty($subject))$stmt->bindValue(":subject", $subject, PDO::PARAM_STR);
  if(!empty($name))$stmt->bindValue(":name", $name, PDO::PARAM_STR);
  if(!empty($huri))$stmt->bindValue(":huri", $huri, PDO::PARAM_STR);
  if(!empty($mail))$stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
  if(!empty($tel))$stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
  if(!empty($train1))$stmt->bindValue(":train1", $train1, PDO::PARAM_STR);
  if(!empty($train2))$stmt->bindValue(":train2", $train2, PDO::PARAM_STR);
  if(!empty($train3))$stmt->bindValue(":train3", $train3, PDO::PARAM_STR);

  foreach ($csv as $row) { 
    
     foreach($row as $v){
    $name =$v;
    $huri =$v;
    $s_no =$v;
    $pass =$v;
    $year =$v;
    $class =$v;
    $subject =$v;
    $mail =$v;
    $tel =$v;
    $train1 =$v;
    $train2 =$v;
    $train3 =$v;
    $stmt->execute();
   }

  }
  $pdo = null;
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
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<H1>CSV生徒取り込み</H1><br>
<!--ファイル取り込みボックス（ファイルをCSVに指定）-->
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="filename" accept=".csv">
<input id="button" type="submit" value="表示" name="表示" >
<input id="button" type="submit" value="登録" name="登録">
</form><br>
    <?php

  
?>
<!-- <input id="input1" type="text" value size="100"> -->
<div class='scroll-table-csv'>
<?php if(!empty($csv)){?>
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
}
    ?>
    </table>
</div>
<div class="float-sample-4">
      <p>　　　　　</p>
</div>
<footer>copyright© チームコリジョン</footer>
</body>
</html>