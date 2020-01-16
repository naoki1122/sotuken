<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";

$pdo = dbcon();


  if(isset($_POST['name'],$_POST['name2'],$_POST['no'],$_POST['password'],$_POST['subject'])){
      $name = $_POST['name'];
      $name2 = $_POST['name2'];
      $no = $_POST['no'];
      $password = $_POST['password'];
      $year = $_POST['year'];
      $class = $_POST['class'];
      $subject = $_POST['subject'];
      
    $stmt = $pdo->prepare("INSERT INTO management.student(名前,フリガナ,学籍番号,パスワード,学年,クラス,学科) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$name,$name2,$no,$password,$year,$class,$subject]);
  echo '登録完了';
}
else{
    $word = "NO";
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="test.css" rel="stylesheet" media="all">
    <title>生徒登録</title>
</head>
<body id="wrap">
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<H1>生徒登録</H1><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
    <section id="input_form">
<ul>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名前</span>
    <input class="inputbox" type="text" name="name" required autofocus placeholder="例：山田太郎"></lavel></li>
    <!--フリガナ-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">フリガナ</span>
    <input class="inputbox" type="text" name="name2" required placeholder="例：ヤマダタロウ"></lavel></li>
    <!--学籍番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">学籍番号</span>
    <input class="inputbox" type="text" name="no" required placeholder="例：x00n000"></lavel></li>
    <!--パスワード-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">パスワード</span>
    <input class="inputbox" type="password" name="password" required placeholder="abcd1234"></lavel></li>
    <!--学年-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学年</span>
    <input class="inputbox" type="text" name="year" required placeholder="1"></lavel></li>
    <!--クラス-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">クラス</span>
    <input class="inputbox" type="text" name="class" required placeholder="1"></lavel></li>
    <!--学科-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学科</span>
    <select class="inputbox" name="subject" required>
        <option value="" selected>学科を選択してください</option>
        <option value="ITエンジニア科4年制">ITエンジニア科4年制</option>
        <option value="ITエンジニア科3年制">ITエンジニア科3年制</option>
        <option value="情報処理科">情報処理科</option>
        <option value="情報ネットワーク科">情報ネットワーク科</option>
        <option value="WEBクリエーター科">WEBクリエーター科</option>
        <option value="こども学科">こども学科</option>
    </select></lavel></li>
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