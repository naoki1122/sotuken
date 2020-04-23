<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";
$pdo = dbcon();

$gobackURL="student_list.php";
$tbl="management.student";

if(empty($_POST['NAME'])) $name = null;
if(empty($_POST['S_NO'])) $s_no = null;
if(empty($_POST['SUBJECT'])) $subject = null;
if(empty($_POST['ROOM'])) $room = null;

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  header("Location:{$gobackURL}");
}else{
$session_name = $_SESSION['名前'];
$session_level = $_SESSION['権限'];
}


// 検索ボタンを押した後の処理
if(isset($_POST['検索']) && isset($_POST['WORD'])){
  $word = $_POST['WORD'];
  $sql = "select 名前,学籍番号,学科,学年,クラス from ${tbl} where ";
  if($_POST['MODE'] == "名前"){
  $sql .= "名前 = :word";
      }else if($_POST['MODE'] == "学籍番号"){
          $sql .= "学籍番号 = :word";
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
}

  if(isset($_POST['削除'])){
    $name = $_POST['NAME'];
    $s_no = $_POST['S_NO'];
    $subject = $_POST['SUBJECT'];
    $room = $_POST['ROOM'];
    $sql = "delete from ${tbl} where 学籍番号 = :s_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
    $stmt->execute();
    echo "
    <script>
        alert('削除完了です'); 
    </script>";
    $name  = "";$s_no = "";$subject = "";$room = "";
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
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<H1>学生削除</H1>
</header>
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
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
  <section id="input_form">
    <ul>
    <!--名前-->
    <li><lavel><span class="item">名前</span><input class="inputbox" type="text" readonly value="<?=$name?>"name="NAME" required></lavel></li>
    <!--学籍番号-->
    <li><lavel><span class="item">学籍番号</span><input class="inputbox" type="text" readonly="readonly" value="<?=$s_no?> "name="S_NO" required></lavel></li>
    <!--学科-->
    <li><lavel><span class="item">学科</span><input class="inputbox" type="text" readonly value="<?=$subject?>" name="SUBJECT"></lavel></li>
    <!--クラス-->
    <li><lavel><span class="item">クラス</span><input class="inputbox" type="text" readonly value="<?=$room?>" name="ROOM"></lavel></li>
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