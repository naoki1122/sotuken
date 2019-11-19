<?php
$user = 'root';
$password = '';
// 利用するデータベース
$dbName = 'management';
// MySQLサーバ
$host = 'localhost';
// MySQLのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }

  if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority'])){
      $name = $_POST['name'];
      $no = $_POST['no'];
      $password = $_POST['password'];
      $authority = $_POST['authority'];
      
    $stmt = $pdo->prepare("insert  into management.teacher(名前,教員番号,パスワード,権限) VALUES (?,?,?,?)");
    $stmt->execute([$name, $no,$password,$authority]);
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
    <title>教員登録</title>
</head>
<body>
<!--戻るのリンク-->
<a href="teacherlist.html">戻る</a>
<H1 id="top">教員登録</H1>
<!--入力フォーム-->
<form id="formmain" action="" method="post">
    <span class="font1">*必須</span>　お名前　　　
    <input id="input" type="text" name="name" required autofocus placeholder="例：山田太郎"><br>
    <span class="font1">*必須</span>　教員番号　　
    <input id="input" type="text" name="no" required placeholder="例：t00x000"><br>
    <span class="font1">*必須</span>　パスワード　
    <input id="input" type="password" name="password" required placeholder="例：abedefg"><br>
    <span class="font1">*必須</span>　権限　　　　
    <select id="input" name="authority" required>
        <option value="" selected>権限を選択してください</option>
        <option value="0">管理者</option>
        <option value="1">一般教員</option>
        <option value="2">アシスタント</option>
    </select><br>
    <input id="button" type="submit" value="登録">
    <input id="button" type="reset" value="リセット">
</form>
<!--copyright-->
<footer>© チームコリジョン2019</footer>
</body>
</html>