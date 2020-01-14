<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
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
      }else if(isset($_POST['word']) && $_POST['mode'] == "学籍番号"){
          $sql = "select * from management.student where 学籍番号 = ?";
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
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$no));
    echo "できた";
  }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="test.css" rel="stylesheet" media="all">
    <title>学生削除</title>
</head>
<body>
<div id="wrap">
<header id="header">
<!--戻るのリンク-->
<p><a href="student_list.php">戻る</a><p>
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
    <li><lavel><span class="item">名前</span><input class="inputbox" type="text" readonlyvalue="<?=$name?> "name="name" required></lavel></li>
    <!--学籍番号-->
    <li><lavel><span class="item">学籍番号</span><input class="inputbox" type="text" readonly value="<?=$no?> "name="no" required></lavel></li>
    <!--学科-->
    <li><lavel><span class="item">学科</span><input class="inputbox" type="text" readonly value="<?=$subject?>" name="subject"></lavel></li>
    <!--クラス-->
    <li><lavel><span class="item">クラス</span><input class="inputbox" type="text" readonly value="<?=$class?>" name="class"></lavel></li>
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
</div>
</body>
</html>