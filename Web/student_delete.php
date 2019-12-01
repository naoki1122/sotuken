<?php
//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
require_once "localhost_config.php";
require_once "lib.php";
$pdo = dbcon();

$name = "";
$no = "";
$subject = "";
$class = "";
$sql = "";
if(isset($_POST['word'])){
  $word = $_POST['word'];
}
else{
    $word = "";
}


if(isset($_POST['検索'])){
  if(isset($_POST['word']) && $_POST['mode'] == "名前"){
  $sql = "select * from management.student where 名前 = ?";
  var_dump($sql);
      }else if(isset($_POST['word']) && $_POST['mode'] == "学籍番号"){
          $sql = "select * from management.student where 学籍番号 = ?";
          var_dump($sql);
  }
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$word]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row){
     $name  = $row["名前"];
     $no = $row["学籍番号"];
     $subject = $row["学科"];
     $class = $row["学年"]."-".$row['クラス'];
  }
}else{
  $cmd = "なし";
}
  if(isset($_POST['削除'])){
    $name = $_POST['name'];
    $no = $_POST['no'];
    $sql = "delete from management.student where 名前 = ? and 学籍番号 = ?";
    var_dump($sql,$no,$name);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$no));
    echo "できた";
  }
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
<a href="student_list.html">戻る</a><br>
<H1>学生削除</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件指定-->
    <select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="学籍番号">学籍番号</option>
    </select><br>
    <!--検索条件入力-->
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->お名前
    <input id="input" type="text" readonly value="<?=$name?>" name="name" required><br>
    <!--教員番号-->学籍番号
    <input id="input" type="text" readonly value="<?=$no?>" name="no" required><br>
    <!--学科-->学科
    <input id="input" type="text" readonly value="<?=$subject?>" name="subject"><br>
    <!--クラス-->クラス
    <input id="input" type="text" readonly value="<?=$class?>" name="class"><br>
    <input id="button" type="submit" value="削除" name="削除"onclick="return checkdelete()">
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