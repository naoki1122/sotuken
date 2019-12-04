<?php
// セッションの開始
session_start();

$name = htmlspecialchars( $_SESSION[ 'name' ], ENT_QUOTES, 'UTF-8' );
$email = htmlspecialchars( $_SESSION[ 'email' ], ENT_QUOTES, 'UTF-8' );
$message = htmlspecialchars( $_SESSION[ 'message' ], ENT_QUOTES, 'UTF-8' );

// 接続設定
  $user = 'root';
  $pass = '';

  // データベースに接続
 $dsn = 'mysql:dbname=form;host=localhost;charset=utf8';
 $conn = new PDO($dsn, $user, $pass); //「$conn」は、任意のオブジェクト名

  // データの追加
 $sql = 'INSERT INTO form(name, email, message) VALUES("'.$name.'","'.$email.'","'.$message.'")';
 $stmt = $conn -> prepare($sql);
 $stmt -> execute();


?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ユーザー登録フォーム・登録ページ</title>
</head>

<body>
<p>ご登録ありがとうございました。</p>
<p><a href="input.php">入力画面に戻る</a></p>
</body>
</html>