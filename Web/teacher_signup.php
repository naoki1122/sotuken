<?php

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
  echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
  echo "<a href='/logout.php'>ログアウトはこちら。</a>";
  exit;
}

 ?>

<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <link href="contents.css" rel="stylesheet" media="all">
   <title>教員ログイン</title>
 </head>
 <body>
   <h1>ようこそ、ログインしてください。</h1>
   <form  action="login.php" method="post">
     <label for="name">教員番号</label>
     <input type="text" name="教員番号">
     <label for="password">パスワード</label>
     <input type="password" name="パスワード">
     <button id="login" type="submit" value="ログイン"></button>
   </form>
 </body>
</html>