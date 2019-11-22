

<?php
$dsn = 'mysql:dbname=management;host=localhost;charset=utf8';
$user = 'root';
$password = '';

session_start();

//DB内でPOSTされたメールアドレスを検索
try {
  $pdo = new PDO($dsn, $user, $password);
  $stmt = $pdo->prepare('select * from teacher where 教員番号 = ?');
  $stmt->execute([$_POST['教員番号']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
var_dump($row['パスワード']);
//emailがDB内に存在しているか確認
if (!isset($row['教員番号'])) {
  echo 'メールアドレス又はパスワードが間違っています。';
  return ;
}
//パスワード確認後sessionにメールアドレスを渡す
if ($_POST['パスワード'] == $row['パスワード']) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['教員番号'] = $row['教員番号'];
  echo 'ログインしました';
	exit;
} else {
  echo 'ユーザー名又はパスワードが間違っています。';
  return false;
}
?>