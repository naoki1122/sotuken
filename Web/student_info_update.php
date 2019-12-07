<?php
session_start();
require_once('server_config.php');
try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $day="";
  $attend = "";
  $word = $_SESSION['word'];
  if(isset($_POST['検索'])){
    if(isset($_POST['day'])){
    $day = $_POST['day'];
    }else{
    $day="";
  }
}
  $sql = 'select * from management.attend where 学籍番号 = ? and 登校日 = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($word,$day));
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($result as $row){
      $day = $row['登校日'];
      $attend = $row['登校時間'];
  }
  var_dump($word);

  if(isset($_POST['変更'])){
      if(isset($_POST['attend'],$_POST['day'])){
        $sql = "update management.attend set  登校日 = ?,登校時間 = ? where  学籍番号 = ? ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($day,$attend,$word));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $_SESSION = array();
            }
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }
  $pdo = null;
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>学生削除</title>
</head>
<body>
<!--戻るのリンク-->
<a href="student_info.php">戻る</a><br>
<H1>生徒出席情報変更</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件入力-->　　　
    <input id="input" type="text" name="day" required autofocus placeholder="日付の入力"><br>
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->日付
    <input id="input" type="text" readonly value="<?=$day?>" name="day"><br>
    <!--教員番号-->出席時刻
    <input id="input" type="text"  value="<?=$attend?>" name="attend" ><br>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkdelete()">
</form>
<!--copyright-->
<footer><p>copyright© チームコリジョン</p></footer>
</body>
</html>