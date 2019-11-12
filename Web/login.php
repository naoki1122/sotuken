

<?php
$dsn = 'mysql:dbname=test_login;host=localhost;charset=utf8';
$user = 'root';
$password = '';


session_start();
//POSTのvalidate
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  ?>
  <meta http-equiv="refresh" content=" 5; url=signUp.php">
  <?php
}
//DB内でPOSTされたメールアドレスを検索
try {
  $pdo = new PDO($dsn, $user, $password);
  $stmt = $pdo->prepare('select * from userDeta where email = ?');
  $stmt->execute([$_POST['email']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//emailがDB内に存在しているか確認
if (!isset($row['email'])) {
  echo 'メールアドレス又はパスワードが間違っています。';
  return ;
}
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'], $row['password'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['EMAIL'] = $row['email'];
  echo 'ログインしました';
	exit ;
} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}
?>