<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";


session_start();
$gobackURL="student_list.php";
$tbl="management.teacher";

if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
  }
  // MySQLデータベースに接続する
  $pdo = dbcon();

 if(isset($_POST['登録'])){
   if(isset($_POST['NAME_UP'],$_POST['NAME_DOWN'],$_POST['T_NO'],$_POST['PASSWD'],$_POST['AUTHORITY'])){
    // 変数代入
    $name_up = $_POST['NAME_UP'];
    $name_down = $_POST['NAME_DOWN'];
    $name = $name_up. " " . $name_down;
    $t_no = $_POST['T_NO'];
    $pass = $_POST['PASSWD'];
    $authority = $_POST['AUTHORITY'];
    // パスワードの入力制限
    //    if(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,15}+\z/i', $_POST['PASSWD'])) {
    //      $password = $_POST['password'];
    //    }else{
    //      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    //      return false;
       }
       $sql = "INSERT INTO ${tbl}(名前,教員番号,パスワード,権限) VALUES (:name,:t_no,:pass,:authority)";
       $stmt = $pdo->prepare($sql);
       $stmt->bindValue(":name", $name, PDO::PARAM_STR);
       $stmt->bindValue(":t_no", $t_no, PDO::PARAM_STR);
       $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
       $stmt->bindValue(":authority", $authority, PDO::PARAM_STR);
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
    <title>教員登録</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>教員登録</H1>
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
    <!--教員番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">教員番号</span>
    <input class="inputbox" type="text" name="T_NO" required placeholder="例：t00n00"></lavel></li>
    <!--パスワード-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">パスワード</span>
    <input class="inputbox" type="password" name="PASSWD" required placeholder="abcd1234"></lavel></li>
    <!--権限-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">権限</span>
    <select class="inputbox" name="AUTHORITY" required>
        <option value="" selected>権限を選択してください</option>
        <option value="0">管理者</option>
        <option value="1">一般教員</option>
        <option value="2">アシスタント</option>
    </select></lavel></li>
</ul>
    <!--登録ボタン-->
    <input id="button" type="submit" value="登録" name="登録" >
    <!--リセットボタン-->
    <input id="button" type="reset" value="リセット" onclick="return resetcheck()">
</section>
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