<?php

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>timedate</title>
</head>

<body>
<p>時間差</p>
<form action="action.php" method="post">
<table>
<tr><th>登録時間</th><td><input type="text" name="touroku" required></td></tr>
</table>
<input type="submit" value="確認画面へ">
</form>
</body>
</html>

<?php

	// UNIX TIMESTAMPを取得
	$timestamp = time() ;
	// 曜日の配列
	$weekday = array( '日' , '月' , '火' , '水' , '木' , '金' , '土' ) ;
 
	// date()で日時を出力
	echo date( "Y年m月j日 " .$weekday[ date('w') ]."曜日 A H時i分s秒" , $timestamp ) ;
?>
