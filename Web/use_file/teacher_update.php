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

    if(isset($_POST['WORD'])) $word = $_POST['WORD'];
    if(empty($_POST['WORD'])) $word = null;
  // 変数代入
  if(isset($_POST['NAME_UP']))$name_up = $_POST['NAME_UP'];
  if(isset($_POST['NAME_DOWN']))$name_down = $_POST['NAME_DOWN'];
  if(isset($_POST['T_NO']))$t_no = $_POST['T_NO'];
  if(isset($_POST['PASSWD']))$pass = $_POST['PASSWD'];
  if(isset($_POST['AUTHORITY']))$authority = $_POST['AUTHORITY'];
  
    // なければnull
    if(empty($_POST['NAME_UP']))$name_up = null;
    if(empty($_POST['NAME_DOWN']))$name_down = null;
    if(empty($_POST['T_NO']))$t_no = null;
    if(empty($_POST['PASSWD']))$pass = null;
    if(empty($_POST['AUTHORITY']))$authority = null;
  

  // 検索
  if(isset($_POST['検索'])){
      // 名前検索
    if(isset($word) && $_POST['MODE'] == "名前"){
        $mode = "名前";
        setcookie("word",$_POST['WORD']);
        setcookie("mode",$_POST['MODE']);
        $sql = "select 名前,教員番号,パスワード,権限 from ${tbl} where 名前 = :word";
      // 教員番号検索
    }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
        $mode = "教員番号";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select 名前,教員番号,パスワード,権限 from ${tbl} where 教員番号 = :word";
    }
    $stmt = $pdo->prepare($sql);
    if(!empty($word))$stmt->bindValue(":word", $word, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $names  = $row["名前"];
       $t_no = $row["教員番号"];
       $pass = $row['パスワード'];
       $authority = $row["権限"];
    }
    $name=explode(" ",$names);
    $name_up=$name[0];
    $name_down=$name[1];

    // ダウンリストに検索の結果を反映させる
    if($row['権限'] == 0) {$admin_selects="selected";$general_selects="";$assistant_selects="";}
    else if($row['権限'] == 1) {$general_selects="selected";$admin_selects="";$assistant_selects="";}
    else if($row['権限'] == 2) {$assistant_selects="selected";$admin_selects="";$general_selects="";}
}else{
    $cmd = "なし";
}
    // 更新
if(isset($_POST['変更'])){
    $admin_selects="";
    $general_selects="";
    $assistant_selects="";
    $name = $name_up." ".$name_down;
    $mode = $_COOKIE['mode'];
    $word = $_COOKIE['word'];
    $sql = "UPDATE ${tbl} SET ";
    if(!empty($_POST['name'])) {
        $name = $_POST['name'];
        $sql .= "名前 = :name ";
    }

    if(!empty($_POST['no'])){
        if(isset($_POST['name'])) {$sql .= ", ";}
        $no = $_POST['no'];$sql .= "教員番号 = :no ";
    }

    if(!empty($_POST['authority'])){
        if((isset($name)) or (isset($no))){ $sql .= ", ";}
        $authority = $_POST['authority']; $sql .= "権限 = :authority ";
    }

    if(!empty($_POST['password'])){
        if((isset($name)) or (isset($no)) or (isset($authority))){
            $sql .= ", ";
        }
        $password = $_POST['password']; 
        $sql .= "パスワード = :password ";
    }

    if($mode == "名前"){$sql .= "WHERE 名前 = :word";}
    else if($mode == "教員番号"){$sql .= "WHERE 教員番号 = :word";}
    $stmt = $pdo->prepare($sql);

    if(!empty($name)) $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    if(!empty($t_no)) $stmt->bindValue(":no", $t_no, PDO::PARAM_STR);
    if(!empty($authority)) $stmt->bindValue(":authority", $authority, PDO::PARAM_INT);
    if(!empty($pass)) $stmt->bindValue(":password", $pass, PDO::PARAM_STR);

    if ($stmt) {
        echo "成功";
    } else {
        echo "失敗";
    }
//     echo "できた";


    if($authority == 0){$admin_selects="selected";$general_selects="";$assistant_selects="";}
    else if($authority == 1){$general_selects="selected";$admin_selects="";$assistant_selects="";}
    else if($authority == 2){$assistant_selects="selected";$admin_selects="";$general_selects="";}
    }
    
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <input id="input1" type="text" name="WORD" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索">
    </ul>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <section id="input_form">
<ul>
    <!--苗字-->
    <li><lavel><span class="item">性</span>
    <input class="inputbox" type="text" value="<?=$name_up?>" name="NAME_UP"  placeholder="例：山田"></lavel></li>
    <!--名前-->
    <li><lavel><span class="item">名</span>
    <input class="inputbox" type="text" value="<?=$name_down?>" name="NAME_DOWN" placeholder="例：太郎"></lavel></li>
    <!--教員番号-->
    <li><lavel><span class="item">教員番号</span>
    <input class="inputbox" type="text" value="<?=$t_no?>" name="T_NO"></lavel></li>
    <!--パスワード-->
    <li><lavel><span class="item">パスワード</span>
    <input class="inputbox" type="password" value="<?=$pass?>" name="PASSSWD"></lavel></li>
    <!--権限選択-->
    <li><lavel><span class="item">権限</span>
    <select class="inputbox" name="AUTHORITY" value="<?=$authority?>">
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