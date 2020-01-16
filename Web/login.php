<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";

session_start();

//DB内でPOSTされたメールアドレスを検索
try {
  $pdo = new PDO(DSN,DB_USER,DB_PASS);
  $stmt = $pdo->prepare('select * from teacher where 名前 = ?');
  $stmt->execute([$_POST['名前']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//emailがDB内に存在しているか確認
if (!isset($row['名前'])) {
  echo '名前又はパスワードが間違っています。';
  return ;
}
//パスワード確認後sessionにメールアドレスを渡す　password_verify
if ($_POST['パスワード']==$row['パスワード']) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['名前'] = $row['名前'];
  $_SESSION['権限'] = $row['権限'];
  echo 'ログインしました';
  header("Location:main.php");
	exit;
} else {
  echo '名前又はパスワードが間違っています。';
  ?>
  <meta http-equiv="refresh" content=" 2; url=teacher_signup.html">
  <?php

}
?>