<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";


$gobackURL="student_list.php";
$tbl="management.student";

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
  }

$pdo = dbcon();

  if(isset($_POST['NAME_UP'],$_POST['NAME_DOWN'],$_POST['HURI'],$_POST['S_NO'],
  $_POST['PASSWD'],$_POST['YEAR'],$_POST['CLASS'],$_POST['SUBJECT'])){
      // 変数代入
      $name_up = $_POST['NAME_UP'];
      $name_down = $_POST['NAME_DOWN'];
      $name = $name_up. " " . $name_down;
      $huri = $_POST['HURI'];
      $s_no = $_POST['S_NO'];
      $pass = $_POST['PASSWD'];
      $year = $_POST['YEAR'];
      $class = $_POST['CLASS'];
      $subject = $_POST['SUBJECT'];
      $sql = "INSERT INTO ${tbl}(名前,フリガナ,学籍番号,パスワード,学年,クラス,学科) 
      VALUES (:name,:huri,:s_no,:pass,:year,:class,:subject)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":name", $name, PDO::PARAM_STR);
      $stmt->bindValue(":huri", $huri, PDO::PARAM_STR);
      $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
      $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
      $stmt->bindValue(":year", $year, PDO::PARAM_INT);
      $stmt->bindValue(":class", $class, PDO::PARAM_INT);
      $stmt->bindValue(":subject", $subject, PDO::PARAM_STR);
    $stmt->execute();
  echo '登録完了';
}
else{
    echo "no";
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>生徒登録</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>生徒登録</H1>
</header>
<!--入力フォーム-->
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
    <section id="input_form">
<ul>
    <!--苗字-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">性</span>
    <input class="inputbox" type="text" name="NAME_UP" required autofocus placeholder="例：山田"></lavel></li>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名</span>
    <input class="inputbox" type="text" name="NAME_DOWN" required autofocus placeholder="例：太郎"></lavel></li>
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
    <input class="inputbox" type="number" name="YEAR" required placeholder="1"></lavel></li>
    <!--クラス-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">クラス</span>
    <input class="inputbox" type="number" name="CLASS" required placeholder="1"></lavel></li>
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
    <input class="inputbox" type="email" name="MAIL" placeholder="1"></lavel></li>
    <!--電話番号-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">電話番号</span>
    <input class="inputbox" type="number" name="TEL" placeholder="1"></lavel></li>
    <!--路線1-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">路線1</span>
    <input class="inputbox" type="text" name="TRAIN1" placeholder="1"></lavel></li>
    <!--路線2-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">路線2</span>
    <input class="inputbox" type="text" name="TRAIN2" placeholder="1"></lavel></li>
    <!--路線3-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">路線3</span>
    <input class="inputbox" type="text" name="TRAIN3" placeholder="1"></lavel></li>
</ul>
    <!--登録ボタン-->
    <input id="button" type="submit" value="登録" >
    <!--リセットボタン-->
    <input id="button" type="reset" value="リセット" onclick="return resetcheck()">
</secion>
</form>
<!--確認ポップアップ用javascript-->
<script>
    //リセット確認
    function resetcheck(){
        return confirm('リセットしてもよろしいですか？');
    }
    //登録確認
    function checksubmit(){
        return confirm('この内容で登録してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>