<?php
// セッションの開始
session_start();

$name = htmlspecialchars( $_POST[ 'name' ], ENT_QUOTES, 'UTF-8' );
$email = htmlspecialchars( $_POST[ 'email' ], ENT_QUOTES, 'UTF-8' );
$message = htmlspecialchars( $_POST[ 'message' ], ENT_QUOTES, 'UTF-8' );

// 入力値をセッション変数に格納
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['message'] = $message;
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ユーザー登録フォーム・確認画面</title>
</head>

<body>
<p>ユーザー登録フォーム・確認画面</p>
<form action="submit.php" method="post">
<table>
<tr><th>お名前</th><td><?php echo $name; ?></td></tr>
<tr><th>メールアドレス</th><td><?php echo $email; ?></td></tr>
<tr><th>お問い合わせ内容</th><td><?php echo $message; ?></td></tr>
</table>
<input type="submit" value="データベースに登録">
</form>
</body>
</html>