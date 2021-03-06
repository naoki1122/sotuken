<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";

$gobackURL = "teacher_list.php";
$tbl="management.teacher";

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
  }
  // MySQLデータベースに接続する
    $pdo = dbcon();

    
  // 変数代入
  if(isset($_POST['WORD'])) $word = $_POST['WORD'];
  if(isset($_POST['NAME']))$name = $_POST['NAME'];
  if(isset($_POST['T_NO']))$t_no = $_POST['T_NO'];
  if(isset($_POST['PASSWD']))$pass = $_POST['PASSWD'];
  if(isset($_POST['AUTHORITY']))$authority = $_POST['AUTHORITY'];
  
  // なければnull
  if(empty($_POST['WORD'])) $word = null;
  if(empty($_POST['NAME']))$name = null;
  if(empty($_POST['T_NO']))$t_no = null;
  if(empty($_POST['PASSWD']))$pass = null;
  if(empty($_POST['AUTHORITY']))$authority = null;


  // 検索
  if(isset($_POST['検索'])){
      // 名前検索
    if(!empty($word) && $_POST['MODE'] == "名前"){
        $mode = "名前";
        setcookie("word",$_POST['WORD']);
        setcookie("mode",$_POST['MODE']);
        $sql = "select 名前,教員番号,パスワード,権限 from ${tbl} where 名前 = :word";
      // 教員番号検索
    }else if(!empty($word) && $_POST['MODE'] == "教員番号"){
        $mode = "教員番号";
        setcookie("word",$_POST['WORD']);
        setcookie("mode",$_POST['MODE']);
        $sql = "select 名前,教員番号,パスワード,権限 from ${tbl} where 教員番号 = :word";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":word", $word, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $name  = $row["名前"];
       $t_no = $row["教員番号"];
       $pass = $row['パスワード'];
       $authority = $row["権限"];
    }

    // ダウンリストに検索の結果を反映させる
    if($row['権限'] == 0) {$admin_selects="selected";$general_selects="";$assistant_selects="";}
    else if($row['権限'] == 1) {$general_selects="selected";$admin_selects="";$assistant_selects="";}
    else if($row['権限'] == 2) {$assistant_selects="selected";$admin_selects="";$general_selects="";}
}

    // 更新
if(isset($_POST['変更']) && (isset($_POST))){
    $admin_selects="";
    $general_selects="";
    $assistant_selects="";
    $mode = $_COOKIE['mode'];
    $word = $_COOKIE['word'];
    $sql = "UPDATE ${tbl} SET ";

    if(!empty($name)){
        $sql .= "名前 = :name ";
    }
    if(!empty($t_no)){
        if(!empty($name)){$sql .= ", ";}
        $sql .= "教員番号 = :t_no ";
    }
    if(!empty($authority)){
        if((!empty($name))||(!empty($t_no))){$sql .= ", ";}
        $sql .= "権限 = :authority ";
    }
    if(!empty($pass)){
        if((!empty($name))||(!empty($t_no))||(!empty($authority))){$sql .= ", ";}
        $sql .= "パスワード = :pass ";
    }

    if($mode == "名前"){$sql .= "WHERE 名前 = :word";}
    else if($mode == "教員番号"){$sql .= "WHERE 教員番号 = :word";}
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":word", $word, PDO::PARAM_STR);
    if(!empty($name)) $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    if(!empty($t_no)) $stmt->bindValue(":t_no", $t_no, PDO::PARAM_STR);
    if(!empty($authority)) $stmt->bindValue(":authority", $authority, PDO::PARAM_STR);
    if(!empty($pass)) $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    $stmt->execute();
    $name="";
    $t_no="";
    $authority="";
    $pass="";
    }
    
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>教員情報変更</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='teacher_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<!-- タイトル -->
<H1>教員情報変更</H1>
</header>

<!--検索フォーム-->
<form id ="form_search" action="" method="post">
    <!--検索条件指定-->
    <ul>
    <li><select id="input1" name="MODE" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="教員番号">教員番号</option>
    </select></li>
    <!--検索条件入力-->
    <input id="input1" type="text" name="WORD" autofocus autocomplete="off" required >
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索">
    </ul>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <section id="input_form">
<ul>
    <!--名前-->
    <li><lavel><span class="item">名前</span>
    <input class="inputbox" type="text" value="<?=$name?>" name="NAME" placeholder="例：山田太郎" required autocomplete="off"></lavel></li>
    <!--教員番号-->
    <li><lavel><span class="item">教員番号</span>
    <input class="inputbox" type="text" value="<?=$t_no?>" name="T_NO" pattern="(^t\d{2}[a-z]\d{3}$)" title="学籍番号はtを含む正規の形で入力してください。" required autocomplete="off"></lavel></li>
    <!--パスワード-->
    <li><lavel><span class="item">パスワード</span>
    <input class="inputbox" type="password" value="<?=$pass?>" name="PASSWD" required autocomplete="off"></lavel></li>
    <!--権限選択-->
    <li><lavel><span class="item">権限</span>
    <select class="inputbox" name="AUTHORITY" value="<?=$authority?>" required>
        <option value="" selected>権限を選択し直してください</option>
        <option value="0"<?=$admin_selects?>>管理者</option>
        <option value="1"<?=$general_selects?>>一般教員</option>
        <option value="2"<?=$assistant_selects?>>アシスタント</option>
    </select></lavel></li>
</ul>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
    </section>
</form>
<script>
    function checkupdate(){
        return confirm('この内容で登録してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>