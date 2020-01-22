<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";
$pdo = dbcon();

$gobackURL="student_list.php";
$tbl="management.student";

$name = "";
$s_no = "";
$subject = "";
$room = "";

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
$session_name = $_SESSION['名前'];
$session_level = $_SESSION['権限'];
}

if(isset($_POST['WORD'])) $word = $_POST['WORD'];
if(isset($_POST['検索']) or !empty($word)){
  if(isset($_POST['WORD']) && $_POST['MODE'] == "名前"){
  $sql = "select * from ${tbl} where 名前 = :word";
      }else if(isset($_POST['word']) && $_POST['mode'] == "学籍番号"){
          $sql = "select 名前 from ${tbl} where 学籍番号 = :word";
  }
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":word", $word, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row){
     $name  = $row["名前"];
     $s_no = $row["学籍番号"];
     $subject = $row["学科"];
     $room = $row["学年"]."-".$row['クラス'];
  }
}else{
  $cmd = "なし";
}
  if(isset($_POST['削除'])){
   
    $sql = "delete from ${tbl} where  学籍番号 = :s_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
    $stmt->execute();
    echo "できた";
  
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>学生削除</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>学生削除</H1>
</header>
<!--検索フォーム-->
<form id ="form_search" action="" method="post">
    <!--検索条件指定-->
    <ul>
    <li><select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="学籍番号">学籍番号</option>
    </select></li>
    <!--検索条件入力-->
    <li><input id="input1" type="text" name="word" autofocus autocomplete="off"></li>
    <!--検索ボタン-->
    <li><input id="button" type="submit" value="検索" name="検索"></li>
    </ul>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
  <section id="input_form">
    <ul>
    <!--名前-->
    <li><lavel><span class="item">名前</span><input class="inputbox" type="text" readonly value="<?=$name?> "name="NAME" required></lavel></li>
    <!--学籍番号-->
    <li><lavel><span class="item">学籍番号</span><input class="inputbox" type="text" readonly value="<?=$s_no?> "name="S_NO" required></lavel></li>
    <!--学科-->
    <li><lavel><span class="item">学科</span><input class="inputbox" type="text" readonly value="<?=$subject?>" name="SUBJECT"></lavel></li>
    <!--クラス-->
    <li><lavel><span class="item">クラス</span><input class="inputbox" type="text" readonly value="<?=$room?>" name="CLASS"></lavel></li>
    </ul>
    <!--削除ボタン-->
    <input id="button" type="submit" value="削除" name="削除"onclick="return checkdelete()">
    </section>
</form>
<script>
    function checkdelete(){
        return confirm('本当に削除してもよいですか？\nこの操作は取り消せません。');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>