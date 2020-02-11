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

// ファイルが選択してあれば$fileにファイル名を代入
if(!empty($_FILES))$file = $_FILES['filename']['name'];

// ファイルを選択した状態で表示ボタンを押した処理
if((isset($_POST['表示']))&&(!empty($file))||(!empty($_COOKIE["file"]))){
setlocale(LC_ALL, 'ja_JP.UTF-8');


if(!empty($file)){ // ファイルが選択されていたら
  setcookie("file",$file);
  $data = file_get_contents($file);
}elseif(!empty($_COOKIE["file"])){ // ファイルが選択してない、クッキーがある
  $data = file_get_contents($_COOKIE["file"]);
}

$data = mb_convert_encoding($data, 'UTF-8', 'auto'); // 文字コード変換処理
$temp = tmpfile();
$csv  = array();
fwrite($temp, $data);
rewind($temp);

 // ファイル内のデータを$csv[]に格納
while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
    $csv[] = $data;
}
fclose($temp);
}elseif(empty($file)){
  echo "
    <script>
        alert('ファイルを選択してください'); 
    </script>";
}

if((isset($_POST['登録']))&&(!empty($_COOKIE["file"]))){
  setlocale(LC_ALL, 'ja_JP.UTF-8');


  if(!empty($file)){ // ファイルが選択されていたら
    setcookie("file",$file);
    $data = file_get_contents($file);
  }elseif(!empty($_COOKIE["file"])){ // ファイルが選択してない、クッキーがある
    $data = file_get_contents($_COOKIE["file"]);
  }
  
  $data = mb_convert_encoding($data, 'UTF-8', 'auto'); // 文字コード変換処理
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
  $sql = "INSERT INTO ${tbl}(学籍番号,学年,クラス,学科,名前,フリガナ,メールアドレス,電話番号,路線1,路線2,路線3) VALUES (:s_no,:year,:class,:subject,:name,:huri,:mail,:tel,:train1,:train2,:train3)";
  $stmt = $pdo->prepare($sql);
  $pdo->beginTransaction();
  foreach ($csv as $row) { 
    $stmt->bindValue(":s_no", $row[0], PDO::PARAM_STR);
    $stmt->bindValue(":year", $row[1], PDO::PARAM_INT);
    $stmt->bindValue(":class", $row[2], PDO::PARAM_INT);
    $stmt->bindValue(":subject", $row[3], PDO::PARAM_STR);
    $stmt->bindValue(":name", $row[4], PDO::PARAM_STR);
    $stmt->bindValue(":huri", $row[5], PDO::PARAM_STR);
    $stmt->bindValue(":mail", $row[6], PDO::PARAM_STR);
    $stmt->bindValue(":tel", $row[7], PDO::PARAM_STR);
    $stmt->bindValue(":train1", $row[8], PDO::PARAM_STR);
    $stmt->bindValue(":train2", $row[9], PDO::PARAM_STR);
    $stmt->bindValue(":train3", $row[10], PDO::PARAM_STR);
    $stmt->execute();
  }
  echo "
    <script>
        alert('登録完了です'); 
    </script>";
  $pdo->commit();
    $pdo = null;
// }elseif(empty($file)){
//   echo "
//     <script>
//         alert('ファイルを選択してください'); 
//     </script>";
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
<input type="file" value="filename" name="filename" accept=".csv">
<input id="button" type="submit" value="表示" name="表示" >
<input id="button" type="submit" value="登録" name="登録">
<p>選択中 <?= $_COOKIE["file"];?></p>
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