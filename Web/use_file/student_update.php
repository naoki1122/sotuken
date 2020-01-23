<?php
session_start();
require_once "server_config.php";
require_once "lib.php";

$gobackURL = "student_list.php";
if(isset($_POST['word'])){
    $word = $_POST['word'];
  }
  else{
      $word = "";
  }
  if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $account = $_SESSION['名前'];
  $level = $_SESSION['権限'];
  }
var_dump($account);
$pdo = dbcon();
$tbl= "management.student";

//   $name="";$name2="";$no="";$account="";
//   $class="";$class2="";$password="";$tel="";
//   $train1="";$train2="";$train3="";$mail="";$subject="";
  
//   $authority;
//   $sql;


if(empty($_POST['NAME'])) $name = null;
if(empty($_POST['T_NO'])) $t_no = null;
if(empty($_POST['PASSWD'])) $pass = null;
if(empty($_POST['AUTHORITY'])) $authority = null;

  // 検索
  if(isset($_POST['検索'])){
      // 名前検索
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
        $mode = "名前";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select * from ${tbl} where 名前 = ?";
        // 学籍番号検索
    }else if(isset($_POST['word']) && $_POST['mode'] == "学籍番号"){
        $mode = "学籍番号";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select * from ${tbl} where 学籍番号 = ?";
    }else{
        header("Location:{$gobackURL}");
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($word));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
        $no = $row["学籍番号"];
       $name  = $row["名前"];
       $name2  = $row["フリガナ"];
       $class  = $row["クラス"];
       $class2  = $row["学科"];
       $email  = $row["メールアドレス"];
       $tel = $row["電話番号"];
       $password = $row["パスワード"];
       $train1 = $row["路線1"];
       $train2 = $row["路線2"];
       $train3 = $row["路線3"];
    }
}
if(isset($_POST['変更'])){
    $mode = $_COOKIE['mode'];
    if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "名前"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $word = $_COOKIE['word'];
        $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
                パスワード = ?,権限 = ? where 名前 = ?";
    }
    else if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "教員番号"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $word = $_COOKIE['word'];
        $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
                パスワード = ?,権限 = ? where 学籍番号 = ?";
    }
    echo $sql;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$no,$password,$authority,$word));
    }

    // ダウンリストに検索結果を反映させる
    if($subject == 0){$it4_selects="selected";$general_selects="";$assistant_selects="";}
    else if($subject =="ITエンジニア科4年制"){$general_selects="selected";$admin_selects="";$assistant_selects="";}
    else if($subject == "ITエンジニア化3年制"){$assistant_selects="selected";$admin_selects="";$general_selects="";}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="test.css" rel="stylesheet" media="all">
    <title>生徒情報変更</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$account?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<!-- タイトル -->
<H1>生徒情報変更</H1>
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
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索">
</ul>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post">
    <section id="input_form">
<ul>
    <!--学籍番号-->
    <li><lavel><span class="item">学籍番号</span>
    <input class="inputbox" type="text" name="S_NO" value="<?=$no?>" required placeholder="例：x00n000"></lavel></li>
    <!--名前-->
    <li><lavel><span class="item">名前</span>
    <input class="inputbox" type="text" name="NAME" value="<?=$name?>" required></lavel></li>
    <!-- フリガナ -->
    <li><lavel><span class="item">フリガナ</span>
    <input class="inputbox" type="text" name="HURI" value="<?=$name2?>" required placeholder="例：サトウタロウ"></lavel></li>
    <!-- 学年 -->
    <li><lavel><span class="item">学年</span>
    <input class="inputbox" type="text" name="YEAR" value="<?=$class?>" required></lavel></li>
    <!-- クラス -->
    <li><lavel><span class="item">クラス</span>
    <input class="inputbox" type="text" name="CLASS" value="<?=$class2?>" required></lavel></li>
    <!--メールアドレス-->
    <li><lavel><span class="item">メールアドレス</span>
    <input class="inputbox" type="email" name="MAIL" value="<?=$mail?>" required placeholder="例：Example@xxx.com"></lavel></li>
    <!--電話番号-->
    <li><lavel><span class="item">電話番号</span>
    <input class="inputbox" type="tel" name="TEL" value="<?=$tel?>" required placeholder="ハイフンなし"></lavel></li>
    <!--学科-->
    <li><lavel><span class="item">学科</span>
    <select class="inputbox" name="SUBJECT" required>
        <option value="" selected>学科を選択し直してください</option>
        <option value="0"<?=$it4_selects?>>ITエンジニア科4年制</option>
        <option value="1"<?=$it3_selects?>>ITエンジニア化3年制</option>
        <option value="2"<?=$info_selects?>>情報処理科</option>
        <option value="3"<?=$net_selects?>>情報ネットワーク科</option>
        <option value="4"<?=$web_selects?>>WEBクリエーター科</option>
        <option value="5"<?=$child_selects?>>こども学科</option>
    </select></lavel></li>
    <!-- 使用路線1 -->
    <li><lavel><span class="item">使用路線</span>
    <select class="inputbox" name="train1" >
        <option value="" selected>路線(1路線目)を選んでください</option>
        <option value="京成本線">京成本線</option>
        <option value="京成千葉線">京成千葉線</option>
        <option value="新京成">新京成</option>
        <option value="芝山鉄道">芝山鉄道</option>
        <option value="東武アーバンパークライン">東武アーバンパークライン</option>
        <option value="常総線">常総線</option>
        <option value="総武線快速">総武線各停</option>
        <option value="総武線各停">総武線快速</option>
        <option value="外房線">内房線</option>
        <option value="内房線">外房線</option>
        <option value="成田線">成田線</option>
        <option value="常磐線">常磐線各停</option>
        <option value="常磐線">常磐線快速</option>
    </select></lavel></li>
    <!-- 使用路線2 -->
    <li><lavel><span class="item">使用路線2</span>
    <select class="inputbox" name="train2" >
        <option value="" selected>路線(1路線目)を選んでください</option>
        <option value="京成本線-2">京成本線</option>
        <option value="京成千葉線-2">京成千葉線</option>
        <option value="新京成-2">新京成</option>
        <option value="芝山鉄道-2">芝山鉄道</option>
        <option value="東武アーバンパークライン-2">東武アーバンパークライン</option>
        <option value="常総線-2">常総線</option>
        <option value="総武線快速-2">総武線各停</option>
        <option value="総武線各停-2">総武線快速</option>
        <option value="外房線-2">内房線</option>
        <option value="内房線-2">外房線</option>
        <option value="成田線-2">成田線</option>
        <option value="常磐線-2">常磐線各停</option>
        <option value="常磐線-2">常磐線快速</option>
    </select></lavel></li>

    <!-- 使用路線3 -->
    <li><lavel><span class="item">使用路線3</span>
    <select class="inputbox" name="train3" >
    <option value="" selected>路線(1路線目)を選んでください</option>
        <option value="京成本線-3">京成本線</option>
        <option value="京成千葉線-3">京成千葉線</option>
        <option value="新京成-3">新京成</option>
        <option value="芝山鉄道-3">芝山鉄道</option>
        <option value="東武アーバンパークライン-3">東武アーバンパークライン</option>
        <option value="常総線-3">常総線</option>
        <option value="総武線快速-3">総武線各停</option>
        <option value="総武線各停-3">総武線快速</option>
        <option value="外房線-3">内房線</option>
        <option value="内房線-3">外房線</option>
        <option value="成田線-3">成田線</option>
        <option value="常磐線-3">常磐線各停</option>
        <option value="常磐線-3">常磐線快速</option>
    </select></lavel></li>
        <!--パスワード-->
        <li><lavel><span class="item">パスワード</span>
    <input class="inputbox" type="password" name="password" value="<?=$password?>" required placeholder="例：abedefg"></lavel></li>
    </ul>
    <!-- 変更ボタン -->
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
    </section>
</form>
<script>
    function checkupdate(){
        return confirm('この内容で登録変更してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>