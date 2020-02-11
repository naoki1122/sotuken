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
  // MySQLデータベースに接続する
  $pdo = dbcon();

  // 変数代入
if(isset($_POST['NAME']))$name = $_POST['NAME'];
if(isset($_POST['HURI']))$huri = $_POST['HURI'];
if(isset($_POST['S_NO']))$s_no = $_POST['S_NO'];
if(isset($_POST['PASSWD']))$pass = $_POST['PASSWD'];
if(isset($_POST['YEAR']))$year = $_POST['YEAR'];
if(isset($_POST['CLASS']))$class = $_POST['CLASS'];
if(isset($_POST['SUBJECT']))$subject = $_POST['SUBJECT'];
if(isset($_POST['MAIL']))$mail = $_POST['MAIL'];
if(isset($_POST['TEL']))$tel = $_POST['TEL'];
if(isset($_POST['TRAIN1']))$train1 = $_POST['TRAIN1'];
if(isset($_POST['TRAIN2']))$train2 = $_POST['TRAIN2'];
if(isset($_POST['TRAIN3']))$train3 = $_POST['TRAIN3'];
  // なければnull
  if(empty($_POST['NAME']))$name = null;
  if(empty($_POST['HURI']))$huri = null;
  if(empty($_POST['S_NO']))$s_no = null;
  if(empty($_POST['PASSWD']))$pass = null;
  if(empty($_POST['YEAR']))$year = null;
  if(empty($_POST['CLASS']))$class = null;
  if(empty($_POST['SUBJECT']))$subject = null;  
  if(empty($_POST['MAIL']))$mail = null;
  if(empty($_POST['TEL']))$tel = null;
  if(empty($_POST['TRAIN1']))$train1 = null;
  if(empty($_POST['TRAIN2']))$train2 = null;
  if(empty($_POST['TRAIN3']))$train3 = null;

  if(isset($_POST['登録'])){
   if((!empty($name))&&(!empty($huri))&&(!empty($s_no))
   &&(!empty($pass))&&(!empty($year))&&(!empty($class))&&(!empty($subject))){
    $sql = "SELECT COUNT(*) AS cnt FROM ${tbl} WHERE 学籍番号 = :s_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
    $stmt->execute();
    $cnt = $stmt->fetchColumn();
    if($cnt == 0){ 
    // 変数代入
    $sql = "INSERT INTO ${tbl}(名前,フリガナ,学籍番号,パスワード,学年,クラス,学科";
    // 任意で登録するもの
    if(!empty($mail)) $sql .= ",メールアドレス";
    if(!empty($tel))$sql .= ",電話番号";
    if(!empty($train1))$sql .= ",路線1";
    if(!empty($train2))$sql .= ",路線2";
    if(!empty($train3))$sql .= ",路線3";
    $sql .= ")";
    // 任意で登録するもの
    $sql .= " VALUES (:name,:huri,:s_no,:pass,:year,:class,:subject";

    if(!empty($mail)) $sql .= ",:mail";
    if(!empty($tel))$sql .= ",:tel";
    if(!empty($train1))$sql .= ",:train1";
    if(!empty($train2))$sql .= ",:train2";
    if(!empty($train3))$sql .= ",:train3";
    $sql .= ")";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->bindValue(":huri", $huri, PDO::PARAM_STR);
    $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
    $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    $stmt->bindValue(":year", $year, PDO::PARAM_INT);
    $stmt->bindValue(":class", $class, PDO::PARAM_INT);
    $stmt->bindValue(":subject", $subject, PDO::PARAM_STR);
    if(!empty($mail))$stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
    if(!empty($tel))$stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
    if(!empty($train1))$stmt->bindValue(":train1", $train1, PDO::PARAM_STR);
    if(!empty($train2))$stmt->bindValue(":train2", $train2, PDO::PARAM_STR);
    if(!empty($train3))$stmt->bindValue(":train3", $train3, PDO::PARAM_STR);
    $stmt->execute();
    echo "
    <script>
        alert('登録完了です'); 
    </script>";
   }else{ echo "
    <script>
        alert('既に登録済みです'); 
    </script>";}
}
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
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<H1>生徒登録</H1>
</header>
<!--入力フォーム-->
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
    <section id="input_form">
<ul>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名前</span>
    <input class="inputbox" type="text" name="NAME" required placeholder="例：山田太郎"></lavel></li>
    <!--フリガナ-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">フリガナ</span>
    <input class="inputbox" type="text" name="HURI" pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" title="フリガナはカタカナで入力してください。" required placeholder="例：ヤマダタロウ"></lavel></li>
    <!--学籍番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">学籍番号</span>
    <input class="inputbox" type="text" name="S_NO" pattern="(^x\d{2}[a-z]\d{3}$)" title="学籍番号はxを含む正規の形で入力してください。" required placeholder="例：x00n000"></lavel></li>
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
    <!--登録ボタン-->
    <input id="button" type="submit" value="登録" name="登録" >
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