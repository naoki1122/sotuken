<?php
session_start();
$gobackURL = "main.html";
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
  $name = "ゲスト";
  $level = 0;
  // header("Location:{$gobackURL}");
}else{
$name = $_SESSION['名前'];
$level = $_SESSION['権限'];
}

 // タイムゾーンを日本に設定
 date_default_timezone_set('Asia/Tokyo');
 // 現在時刻の取得
 $time = new DateTime();
 $time2 = $time->format('Y-m-d');
 $time = $time->format('m-d');
?>


<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <link href="list.css" rel="stylesheet" media="all">
    <title>教員詳細一覧</title>
</head>

<body>
<!-- ようこそ的なメッセージ 名前抽出わからん-->
<p>ようこそ<?=$name?>さん</p>
<!-- ログアウトボタン 動きはわからん -->
<button type=“button” id="button" onclick="location.href='logout.php'">ログアウト</button>
<H1>本日<?=$time?>の出席状況</H1><br>
<?php
//sotukenサーバー用のDB情報
//require_once('main_config.php');
//ローカル用のサーバー情報
require_once 'localhost_config.php';

try{
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  // クエリ
  $sql = 'SELECT student.学籍番号,student.名前,student.学年,student.クラス,attend.登校時間,attend.登校日,attend.備考 FROM  management.student
  left outer join management.attend
  on student.学籍番号 = attend.学籍番号 WHERE attend.登校日 = ?';
  // SQL文の実効
  $stm = $pdo->prepare($sql);
  $stm->execute(array($time2));
  var_dump($sql);
// 結果の取得（連想配列で受け取る）
$result = $stm->fetchAll(PDO::FETCH_ASSOC);

  ?>
<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>名前</th>
  <th>クラス</th>
  <th>出席状況</th>
  <th>登校時間</th>
  <th>コメント</th>
  </tr>

  <?php
  
  foreach ($result as $row) {
    var_dump($row['学籍番号']); 
  $row['クラス'] = $row['学年']."-".$row['クラス']; 
  if(!empty($row['登校時間'])){
    if($row['登校時間']){
      
    }
  }else{

  }
  
  ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['クラス']);?>
    <td>
    <td><?php print($row['登校時間']);?>
    <td><?php print($row['備考']);?>
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
<!--教員登録リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_insert.php">教員登録</li><br>';
}?>
<!--教員情報変更リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_update.php">教員情報変更</li><br>';
}?>
<!--教員削除リンク-->
<?php if($level == 0){
echo '<li><a href="teacher_delete.php">教員削除</li><br>';
}?>
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