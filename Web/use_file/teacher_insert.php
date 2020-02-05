<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";


$gobackURL="teacher_list.php";
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
  
  // パスワードの入力制限
    //    if(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,15}+\z/i', $_POST['PASSWD'])) {
    //      $password = $_POST['password'];
    //    }else{
    //      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
    //      return false;

 if(isset($_POST['登録'])){
     // すべての入力項目が記入されていると実効
   if((!empty($name_up))&&(!empty($name_down))&&(!empty($t_no))&&(!empty($pass))&&(!empty($authority))){
   $sql = "SELECT COUNT(*) AS cnt FROM ${tbl} WHERE 教員番号 = :t_no";
   $stmt = $pdo->prepare($sql);
   $stmt->bindValue(":t_no", $t_no, PDO::PARAM_STR);
   $stmt->execute();
   $cnt = $stmt->fetchColumn();
   var_dump($name_up);
   var_dump($name_down);
   var_dump($t_no);
   var_dump($pass);
   var_dump($authority);
   var_dump($cnt);
   if($cnt == 0){
    $name = $name_up. " " . $name_down;
    $sql = "INSERT INTO ${tbl}(名前,教員番号,パスワード,権限) VALUES (:name,:t_no,:pass,:authority)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":t_no", $t_no, PDO::PARAM_STR);
    $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    $stmt->bindValue(":authority", $authority, PDO::PARAM_INT);
    $stmt->execute();
    echo '登録完了';
    }
    else {echo "既に登録済み";}
}
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
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
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
    <input class="inputbox" type="text" name="NAME_UP"  autofocus placeholder="例：山田"></lavel></li>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名</span>
    <input class="inputbox" type="text" name="NAME_DOWN"  placeholder="例：太郎"></lavel></li>
    <!--教員番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">教員番号</span>
    <input class="inputbox" type="text" name="T_NO"  placeholder="例：t00n00"></lavel></li>
    <!--パスワード-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">パスワード</span>
    <input class="inputbox" type="password" name="PASSWD"  placeholder="abcd1234"></lavel></li>
    <!--権限-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">権限</span>
    <select class="inputbox" name="AUTHORITY" required>
        <option value="" selected>権限を選択してください</option>
        <option value="1">管理者</option>
        <option value="2">一般教員</option>
        <option value="3">アシスタント</option>
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