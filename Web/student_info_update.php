<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>学生削除</title>
</head>
<body>
<!--戻るのリンク-->
<a href="student_info.php">戻る</a><br>
<H1>生徒出席情報変更</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件入力-->　　　
    <input id="input" type="text" name="name" required autofocus placeholder="日付の入力"><br>
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->日付
    <input id="input" type="text" readonly value="<?=$name?>" name="name" required>
    <!--教員番号-->出席時刻
    <input id="input" type="text" readonly value="<?=$no?>" name="no" required><br>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkdelete()">
</form>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>