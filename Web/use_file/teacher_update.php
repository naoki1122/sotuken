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
    $name=null;
    $no=null;
    $password=null;
    $authority=null;
    $word=null;
    $tbl="management.teacher";
// 検索
  if(isset($_POST['検索'])){
      // 名前検索
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
        $mode = "名前";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select 名前,教員番号,権限 from ${tbl} where 名前 = :word";
      // 教員番号検索
    }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
        $mode = "教員番号";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select 名前,教員番号,権限 from ${tbl} where 教員番号 = :word";
    }else{
        header("Location:{$gobackURL}");
    }
    $stmt = $pdo->prepare($sql);
    if(!empty($word))$stmt->bindValue(":word", $word, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $name  = $row["名前"];
       $no = $row["教員番号"];
       $authority = $row["権限"];
    }
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
    if(!empty($no)) $stmt->bindValue(":no", $no, PDO::PARAM_STR);
    if(!empty($authority)) $stmt->bindValue(":authority", $authority, PDO::PARAM_INT);
    if(!empty($password)) $stmt->bindValue(":password", $password, PDO::PARAM_STR);


    // var_dump($no); echo "<br>";
    // var_dump($name); echo "<br>";
    // var_dump($authority); echo "<br>";
    // var_dump($word); echo "<br>";
    // var_dump($password); echo "<br>";
    // var_dump($stmt);
     $sql = "update management.teacher set 名前 = '$name' , 教員番号 = '$no' , 権限 = $authority , パスワード = '$password' where 名前 = '$word'";
     $stmt = $pdo->query($sql);
    //  $stmt->execute();
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
    <link href="test.css" rel="stylesheet" media="all">
    <title>教員情報変更</title>
</head>
<body id="wrap">

<header id="header">
<!--戻るのリンク-->
<a href="teacher_list.php">戻る</a>
<!-- タイトル -->
<H1>教員情報変更</H1>
<!-- ようこそ的なメッセージ 名前抽出わからん-->
<p>ようこそ　ゲストさん</p>
<!-- ログアウトボタン 動きはわからん -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>

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
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
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
    <input class="inputbox" type="text" value="<?=$name?>"name="name"></lavel></li>
    <!--教員番号-->
    <li><lavel><span class="item">教員番号</span>
    <input class="inputbox" type="text" value="<?=$no?>" name="no"></lavel></li>
    <!--パスワード-->
    <li><lavel><span class="item">パスワード</span>
    <input class="inputbox" type="password" value="<?=$password?>" name="password"></lavel></li>
    <!--権限選択-->
    <li><lavel><span class="item">権限</span>
    <select class="inputbox" name="authority" value="<?=$authority?>">
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