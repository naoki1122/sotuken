<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";

$pdo = dbcon();

$gobackURL="teacher_list.php";
$tbl="management.teacher";

if(empty($_POST['NAME'])) $name = null;
if(empty($_POST['T_NO'])) $t_no = null;
if(empty($_POST['PASSWD'])) $pass = null;
if(empty($_POST['AUTHORITY'])) $authority = null;
  
// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
  }

  

  if(isset($_POST['検索'])){
    if(isset($_POST['word'])) $word = $_POST['word'];
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
    $sql = "select * from ${tbl} where 名前 = :word";
        }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
            $sql = "select * from ${tbl} where 教員番号 = :word";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":word", $word, PDO::PARAM_STR);
    $stmt->execute();
    var_dump($stmt);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $name  = $row["名前"];
       $t_no = $row["教員番号"];
       $pass = $row["パスワード"];
       $authority = $row["権限"];
    }
}else{
    $cmd = "なし";
}
    if(isset($_POST['削除'])){
        $name = $_POST['NAME'];
        $t_no = $_POST['T_NO'];
        $pass = $_POST['PASSWD'];
        $authority = $_POST['AUTHORITY'];
        $sql = "delete from ${tbl} where 名前 = :name and 教員番号 = :t_no and パスワード = :pass and 権限 = :authority";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":t_no", $t_no, PDO::PARAM_STR);
    $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    $stmt->bindValue(":authority", $authority, PDO::PARAM_STR);
    $stmt->execute();
    $name = "";
    $t_no = "";
    $pass = "";
    $authority = "";
    }
    

// if($authority == 0){
//     $rename = "管理者";
// }elseif($authority == 1){
//     $rename ="教員";
// }elseif($authority == 2){
//     $rename ="アシスタント";
// }else{
//     $rename = "";
// }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>教員削除</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<a href="teacher_list.php">戻る</a><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<h1>教員削除</h1>
</header>
<!--検索フォーム-->
<form id ="form_search" action="" method="post">
    <!--検索条件指定-->
    <ul>
    <li><select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="教員番号">教員番号</option>
    </select></li>
    <!--検索条件入力-->
    <li><input id="input1" type="text" name="word" autofocus autocomplete="off"></li>
    <!--検索ボタン-->
    <li><input id="button" type="submit" value="検索" name="検索"></li>
    </ul>
</form>
<!--入力フォーム-->
<form id="form_main" action="" method="post" >
    <section id="input_form">
<ul>
    <!--名前-->
    <li><lavel><span class="item">お名前</span><input class="inputbox" type="text" readonly value="<?=$name?>" name="NAME" required></lavel></li>
    <!--教員番号-->
    <li><lavel><span class="item">教員番号</span><input class="inputbox" type="text" readonly value="<?=$t_no?>" name="T_NO" required></lavel></li>
    <!--パスワード-->
    <li><lavel><span class="item">パスワード</span><input class="inputbox" type="password" readonly value="<?=$pass?>" name="PASSWD"></lavel></li>
    <!--権限-->
    <li><lavel><span class="item">権限</span><input class="inputbox" type="text" readonly value="<?=$authority?>" name="AUTHORITY"></lavel></li>
</ul>
<input id="button" type="submit" value="削除" name="削除" onclick="return checkupdate()">
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