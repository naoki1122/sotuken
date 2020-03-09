<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";
$pdo = dbcon();

$gobackURL="student_info.php";
$tbl="management.student";

  if(isset($_POST['DAY'])) $day = $_POST['DAY'];
  if(isset($_POST['ATTEND'])) $attend = $_POST['ATTEND'];
  if(empty($_POST['DAY'])) $day = null;
  if(empty($_POST['ATTEND'])) $attend = null;

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
$session_name = $_SESSION['名前'];
$session_level = $_SESSION['権限'];
}

  if(isset($_POST['検索'])){
    if(isset($_POST['day'])){
    $day = $_POST['day'];
    
  $sql = 'select * from management.attend where 学籍番号 = ? and 登校日 = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($word,$day));
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($result as $row){
      $day = $row['登校日'];
      $attend = $row['登校時間'];
  }
}
  }
  
  if(isset($_POST['変更'])){
      if(isset($_POST['attend'],$_POST['day'])){
        $sql = "update management.attend set  登校日 = ?,登校時間 = ? where  学籍番号 = ? ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($day,$attend,$word));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $_SESSION = array();
            }
  $pdo = null;
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>生徒出席情報変更</title>
</head>
<body>
  
<header>
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='student_info.php'">戻る</button>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<H1>生徒出席情報変更</H1>
</header>
<div id ="form_all">
  <div id="form_left">
<!--検索フォーム-->
<form id ="form_search" action="" method="post">
    <!--検索条件指定-->
    <ul>
    <li><select id="input1" name="MODE" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="学籍番号">学籍番号</option>
    </select></li>
    <!--検索条件入力-->
    <li><input id="input1" type="text" name="WORD" autofocus autocomplete="off"></li>
    <!--検索ボタン-->
    <li><input id="button" type="submit" value="検索" name="検索"></li>
    </ul>
</form>
  </div>
<div id="form_right">
<!--入力フォーム-->
<form id="form_input" action="" method="post" >
    <!--名前-->日付
    <input id="input1" type="text" readonly value="<?=$day?>" name="day"><br>
    <!--教員番号-->出席時刻
    <input id="input1" type="text"  value="<?=$attend?>" name="ATTEND" ><br>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkdelete()">
</form>
  </div>
</div>
<!--copyright-->
<footer><p>copyright© チームコリジョン</p></footer>
</body>
</html>