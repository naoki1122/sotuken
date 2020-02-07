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
$pdo = dbcon();
$tbl= "management.student";

  $name="";$name2="";$no="";$account="";
  $class="";$class2="";$password="";$tel="";
  $train1="";$train2="";$train3="";$mail="";$subject="";

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
       $subject  = $row["学科"];
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
    
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>生徒情報変更</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$account?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
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
    <!--苗字-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">性</span>
    <input class="inputbox" type="text" name="NAME_UP" required autofocus placeholder="例：山田"></lavel></li>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名</span>
    <input class="inputbox" type="text" name="NAME_DOWN" required  placeholder="例：太郎"></lavel></li>
    <!--フリガナ-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">フリガナ</span>
    <input class="inputbox" type="text" name="HURI" required placeholder="例：ヤマダタロウ"></lavel></li>
    <!--学籍番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">学籍番号</span>
    <input class="inputbox" type="text" name="S_NO" required placeholder="例：x00n000"></lavel></li>
    <!--パスワード-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">パスワード</span>
    <input class="inputbox" type="password" name="PASSWD" required placeholder="abcd1234"></lavel></li>
    <!--学年-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学年</span>
    <input class="inputbox" type="number" name="YEAR" min="1" max="4" value="1" required placeholder="1"></lavel></li>
    <!--クラス-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">クラス</span>
    <input class="inputbox" type="number" name="CLASS" min="1" max="4" value="1" required placeholder="1"></lavel></li>
    <!--学科-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学科</span>
    <select class="inputbox" name="SUBJECT" required>
        <option value="" selected>学科を選択してください</option>
        <option value="ITエンジニア科4年制">ITエンジニア科4年制</option>
        <option value="ITエンジニア科3年制">ITエンジニア科3年制</option>
        <option value="情報処理科">情報処理科</option>
        <option value="情報ネットワーク科">情報ネットワーク科</option>
        <option value="WEBクリエーター科">WEBクリエーター科</option>
        <option value="こども学科">こども学科</option>
    </select></lavel></li>
    <!--メールアドレス-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">メールアドレス</span>
    <input class="inputbox" type="email" name="MAIL"></lavel></li>
    <!--電話番号-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">電話番号</span>
    <input class="inputbox" type="number" name="TEL" placeholder="ハイフンなし"></lavel></li>
    <!-- 使用路線1 -->
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" name="TRAIN1" >
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
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" name="TRAIN2" >
        <option value="" selected>路線(2路線目)を選んでください</option>
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
    <!-- 使用路線1 -->
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" name="TRAIN3" >
        <option value="" selected>路線(3路線目)を選んでください</option>
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