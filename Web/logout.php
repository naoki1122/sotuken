<?php
session_start();
$gobackURL = "teacher_signup.html";
if (isset($_SESSION["名前"])) {
  echo 'Logoutしました。';
  header("Location:{$gobackURL}");
} else {
  echo 'SessionがTimeoutしました。';
  header("Location:{$gobackURL}");
}

//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
//セッションクリア
@session_destroy();