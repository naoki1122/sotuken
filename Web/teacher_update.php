<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";

require_once 'lib.php';

$gobackURL = "teacher_update.php";
// 存在すれば各変数へ代入
if(isset($_POST['word'])) $word = $_POST['word'];

    // DB接続
    $pdo = dbcon();

    // 初期化
    $name = "";
    $no = "";
    $password = "";
    $authority = "";
    $sql = "";

  if(isset($_POST['検索'])){
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
        $mode = "名前";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select 名前,教員番号,権限 from management.teacher where 名前 = :word";
    }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
        $mode = "教員番号";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select 名前,教員番号,権限 from management.teacher where 教員番号 = :word";
    }else{
        header("Location:{$gobackURL}");
    }
    $stmt = $pdo->prepare($sql);
    if(!empty($word))$stmt->bindValue(":word", $word, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $name  = $row["名前"];
       $no = $row["教員番号"];
       $authority = $row["権限"];
    }
    if($row['権限'] == 0) {$admin_selects="selected";$general_selects="";$assistant_selects="";}
    else if($row['権限'] == 1) {$general_selects="selected";$admin_selects="";$assistant_selects="";}
    else if($row['権限'] == 2) {$assistant_selects="selected";$admin_selects="";$general_selects="";}
}else{
    $cmd = "なし";
}
var_dump($mode);
if(isset($_POST['変更'])){
    $admin_selects="";
    $general_selects="";
    $assistant_selects="";
    $mode = $_COOKIE['mode'];
    $word = $_COOKIE['word'];
    if(isset($_POST['name'],$_POST['no'],$_POST['authority']) && $mode == "名前"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $authority = $_POST['authority'];
        $sql = "update management.teacher set 名前 = :name,教員番号 = :no,権限 = :authority ";
    }
    else if(isset($_POST['name'],$_POST['no'],$_POST['authority']) && $mode == "教員番号"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $authority = $_POST['authority'];
        $sql = "update management.teacher set 名前 = :name,教員番号 = :no,権限 = :authority ";
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
        $sql .= "パスワード = :password ";}
    if($mode == "名前"){$sql .= "where 名前 = :word";}
    else if($mode == "教員番号"){$sql .= "where 教員番号 = :word";}
    $stmt = $pdo->prepare($sql);
    if(!empty($name))$stmt->bindValue(":name", $name, PDO::PARAM_INT);
    if(!empty($word))$stmt->bindValue(":no", $no, PDO::PARAM_INT);
    if(!empty($word))$stmt->bindValue(":authority", $authority, PDO::PARAM_INT);
    if(!empty($word))$stmt->bindValue(":word", $word, PDO::PARAM_INT);
    if(!empty($password))$stmt->bindValue(":password", $password, PDO::PARAM_INT);
    $stmt->execute();
    echo "できた";
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
    <link href="contents.css" rel="stylesheet" media="all">
    <title>教員情報変更</title>
</head>
<body>
<!--戻るのリンク-->
<a href="teacher_list.php">戻る</a><br>
<H1>教員情報変更</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件指定-->
    <select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="教員番号">教員番号</option>
    </select><br>
    <!--検索条件入力-->
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->お名前　　　
    <input id="input" type="text" value="<?=$name?>"name="name" required ><br>
    <!--教員番号-->教員番号　　
    <input id="input" type="text" value="<?=$no?>" name="no" required ><br>
    <!--パスワード-->パスワード　
    <input id="input" type="password" value="<?=$password?>" name="password" ><br>
    <!--権限選択-->権限　　　　
    <select id="input" name="authority" value="<?=$authority?>" required>
        <option value="" selected>権限を選択し直してください</option>
        <option value="0"<?=$admin_selects?>>管理者</option>
        <option value="1"<?=$general_selects?>>一般教員</option>
        <option value="2"<?=$assistant_selects?>>アシスタント</option>
    </select><br>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
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