<?php
//sotukenサーバー用のDB情報
require_once("server_config.php");
//ローカル用のサーバー情報
//require_once("localhost_config.php");

try {
    $pdo = new PDO(DSN,DB_USER,DB_PASS);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }

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
    <link href="contents.css" rel="stylesheet" media="all">
    <title>生徒登録</title>
</head>
<body>
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
<H1>生徒登録</H1><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
    <!--名前-->
    <span class="font1">*必須</span>　お名前　　　
    <input id="input" type="text" name="name" required autofocus placeholder="例：山田太郎"><br>
    <!--フリガナ-->
    <span class="font1">*必須</span>　フリガナ　　
    <input id="input" type="text" name="name2" required autofocus placeholder="例：ヤマダタロウ"><br>
    <!--学籍番号-->
    <span class="font1">*必須</span>　学籍番号　　
    <input id="input" type="text" name="no" required placeholder="例：00n000"><br>
    <!--パスワード-->
    <span class="font1">*必須</span>　パスワード　
    <input id="input" type="password" name="password" required placeholder="abcdefg1234"><br>
    <!--学年-->
    <span class="font1">*必須</span>　学年　　　
    <input id="input" type="text" name="year" required placeholder="1"><br>
    <!--クラス-->
    <span class="font1">*必須</span>　クラス　　　
    <input id="input" type="text" name="class" required placeholder="1"><br>
    <!--学科-->
    <span class="font1">*必須</span>　学科　　　　
    <select id="input" name="subject" required>
        <option value="" selected>学科を選択してください</option>
        <option value="ITエンジニア科4年制">ITエンジニア科4年制</option>
        <option value="ITエンジニア化3年制">ITエンジニア化3年制</option>
        <option value="情報処理科">情報処理科</option>
        <option value="情報ネットワーク科">情報ネットワーク科</option>
        <option value="WEBクリエーター科">WEBクリエーター科</option>
        <option value="こども学科">こども学科</option>
    </select><br>
    <!--登録ボタン-->
    <input id="button" type="submit" value="登録" >
    <!--リセットボタン-->
    <input id="button" type="reset" value="リセット" onclick="return resetcheck()">
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