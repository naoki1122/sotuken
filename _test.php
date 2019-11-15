<?php
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>個人情報変更</title>
 <!-- <link href="php7note\chap13\css\style.css" rel="stylesheet">
 テーブル用のスタイルシート
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet"> -->
</head>
<body>
<div>
<form method="POST" action="">
<select name="検索条件">
<option value="名前">名前</option>
<option value="教員番号">教員番号</option>
</select>
        
  <br><label>名前(漢字)（部分一致）</label><br>
        <input type="text" name="名前" placeholder="名前（漢字）" autocomplete="off"><br>
        
      <label>教員番号（部分一致）</label><br>
        <input type="text" name="学籍番号" placeholder="学籍番号" autocomplete="off"><br>

        <label>パスワード</label><br>
        <input type="text" name="学籍番号" placeholder="学籍番号" autocomplete="off">

      <input type="submit" value="検索" >
  </form>
  
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>

