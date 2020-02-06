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

 /* if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $account = $_SESSION['名前'];
  $level = $_SESSION['権限'];
  }*/
var_dump($account);
$pdo = dbcon();
$tbl= "management.student";

  $name="";$name2="";$no="";$account="";
  $class="";$class2="";$password="";$tel="";
  $train1="";$train2="";$train3="";$mail="";$subject="";
  
  $authority;
  $sql;

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
    <link href="form.css" rel="stylesheet" media="all">
    <title>日課表変更</title>
</head>
<body id="wrap" onLoad="functionName()">
<header id="header">
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$account?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<!-- タイトル -->
<H1>日課表変更</H1>
</header>
<!--検索フォーム-->
<form id ="form_search" action="" method="post">
<!--検索条件指定-->
<ul>
    <!--学科指定-->
    <li><select id="input1" name ="subject" requires onChange="functionName()">
    <option value="" selected>学科を指定してください</option>
    <option value = "ITエンジニア科4年制">ITエンジニア科4年制</option>
    <option value = "ITエンジニア科3年制">ITエンジニア科3年制</option>
    <option value = "情報処理科">情報処理科</option>
    <option value = "情報ネットワーク科">情報ネットワーク科</option>
    <option value = "WEBクリエーター科">WEBクリエーター科</option>
    <option value = "こども学科">こども学科</option>
    </select></li>

    <!--学年動的変化用スクリプト-->
    <script>
    function functionName()
    {
    var select1 = document.forms.form_search.subject; //変数select1を宣言
    var select2 = document.forms.form_search.selectName2; //変数select2を宣言
    
    select2.options.length = 0; // 選択肢の数がそれぞれに異なる場合、これが重要
    
    if (select1.options[select1.selectedIndex].value == "ITエンジニア科4年制")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    select2.options[3] = new Option("4年1組");
    }
    
    else if (select1.options[select1.selectedIndex].value == "ITエンジニア科3年制")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    }
    
    else if (select1.options[select1.selectedIndex].value == "情報処理科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("1年2組");
    select2.options[2] = new Option("2年1組");
    select2.options[3] = new Option("2年2組");
    }
    else if (select1.options[select1.selectedIndex].value == "情報ネットワーク科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("1年2組");
    select2.options[2] = new Option("2年1組");
    select2.options[3] = new Option("2年2組");
    }
    else if (select1.options[select1.selectedIndex].value == "WEBクリエーター科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    }
    else if (select1.options[select1.selectedIndex].value == "こども学科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    }
    }
    </script>

    <!--学年クラス指定（動的変化）-->
    <li><select id="input1" name="selectName2">
    </select></li>
    <li><select id="input1" name="semester" required >
        <option value="" selected>学期を指定してください</option>
        <option value="前期">前期</option>
        <option value="後期">後期</option>
    </select></li>
    <!--曜日指定-->
    <li><select id="input1" name="week" required >
        <option value="" selected>曜日を指定してください</option>
        <option value="月曜日">月曜日</option>
        <option value="火曜日">火曜日</option>
        <option value="水曜日">水曜日</option>
        <option value="木曜日">木曜日</option>
        <option value="金曜日">金曜日</option>
    </select></li>
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索">
</ul>
</form>


<!--入力フォーム-->
<form id="formmain" action="" method="post">
    <section id="input_form">
<ul>
    <!--授業選択-->
    <li><lavel><span class="item">1限目</span>
    <select class="inputbox" name="class1" required>
    </select></lavel></li>

    <li><lavel><span class="item">2限目</span>
    <select class="inputbox" name="class2" required>
    </select></lavel></li>

    <li><lavel><span class="item">3限目</span>
    <select class="inputbox" name="class3" required>
    </select></lavel></li>
    </ul>

  <!--授業動的変化用-->
  <script>
    function functionName()
    {
    var select3 = document.forms.form_search.subject; //変数select1を宣言
    var select4 = document.forms.form_search.class1; //変数select2を宣言
    
    select4.options.length = 0; // 選択肢の数がそれぞれに異なる場合、これが重要
    
    if (select3.options[select3.selectedIndex].value == "ITエンジニア科4年制")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    select2.options[3] = new Option("4年1組");
    }
    
    else if (select1.options[select1.selectedIndex].value == "ITエンジニア科3年制")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    }
    
    else if (select1.options[select1.selectedIndex].value == "情報処理科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("1年2組");
    select2.options[2] = new Option("2年1組");
    select2.options[3] = new Option("2年2組");
    }
    else if (select1.options[select1.selectedIndex].value == "情報ネットワーク科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("1年2組");
    select2.options[2] = new Option("2年1組");
    select2.options[3] = new Option("2年2組");
    }
    else if (select1.options[select1.selectedIndex].value == "WEBクリエーター科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    }
    else if (select1.options[select1.selectedIndex].value == "こども学科")
    {
    select2.options[0] = new Option("1年1組");
    select2.options[1] = new Option("2年1組");
    select2.options[2] = new Option("3年1組");
    }
    }
    </script>

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