<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="contents.css" rel="stylesheet" media="all">
    <title>生徒詳細一覧</title>
</head>

<body>
<!--戻るのリンク-->
<a href="student_list.php">戻る</a><br>
    <?php
    session_start();
require_once('server_config.php');
try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $word="";
  if(isset($_POST['検索'])){
    if(isset($_POST['word'])){
    $word = $_POST['word'];
    $_SESSION['word'] = $word;
    }else{
    $word="";
  }
}
  $sql = 'select * from management.attend where 学籍番号 = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$word]);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
<!--検索条件入力-->
<input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form>
<p></p><br>
<!--テーブル云々　抽出とかわからん-->
<div id='style table'>
<table border="1" align="center">
  <tr>
  <th>日付</th>
  <th>出席時刻</th>
  </tr>

  <?php
  foreach ($result as $row) { ?>
    <tr>
    <td><?php print($row['登校日']);?>
    <td><?php print($row['登校時間']);?>
    </tr>
      <?php
  }
    ?>
    </table>
    <div class="float-sample-4">
      <p>　　　　　</p>
    </div>
<!--リスト黒四角つけるタグ-->
<ul style="list-style-type: disc">
<!--出席情報変更リンク-->
<li><a href="student_info_update.php">出席情報変更</a></li><br>
</ul>
    <?php
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
$dbh = null;
?>
<footer>copyright© チームコリジョン</footer>
</body>
</html>