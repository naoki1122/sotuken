<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ユーザー登録フォーム・入力画面</title>
</head>

<body>
<p>ユーザー登録フォーム・入力画面</p>
<form action="confirm.php" method="post">
<table>
<tr><th>お名前</th><td><input type="text" name="name" required></td></tr>
<tr><th>メールアドレス</th><td><input type="email" name="email" cols="50" required></td></tr>
<tr><th>お問い合わせ内容</th><td><textarea name="message"  cols="50" rows="4"></textarea></td></tr>
</table>
<input type="submit" value="確認画面へ">
</form>
</body>
</html>