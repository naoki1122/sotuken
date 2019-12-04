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
 $datetime = new DateTime();
 $year = $datetime->format('Y-m-d');
 $day = $datetime->format('m-d');
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
<H1>本日<?=$day?>の出席状況</H1><br>
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
  $stm->execute(array($year));
// 結果の取得（連想配列で受け取る）
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
//var_dump($result);
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
  
  foreach ($result as $row){
  $msg = "";
  $cmd = "";
  $time = "";
  $time2 ="";
  $time3 = "";
  $i = 1;
  $j = 2;  
  $row['クラス'] = $row['学年']."-".$row['クラス']; 
  if(!empty($row['登校時間'])){
    $attend = new DateTime($row['登校時間']);
    $attend = $attend->format('H:i:s');
    //var_dump($attend);
    $time = array("09:30:00","09:31:00","10:31:00","10:32:00","11:10:00","11:11:00","12:11:00","12:12:00","13:11:00","13:12:00","13:40:00","13:41:00","14:41:00","14:42:00");
    $msg = array("出席","1限遅刻","2限出席","2限遅刻","昼休み出席","3限出席","3限遅刻","欠席");
     //条件式の回数
    // var_dump($max); // 配列の長さ
    for($cnt=0;$cnt <= 7;$cnt++){
       if($cnt == 0){
        $time2 = new DateTime($time[$cnt]);
        $time2 = $time2->format('H:i:s');
        //var_dump($time2);
        //$time2 = new DateTime('00:00:00');
        //var_dump($time[$cnt]);
        if($attend <= $time2){
          $cmd = $msg[$cnt];
        }
      }elseif($cnt >= 1 && $cnt <= 6){
        $time2 = "";
        $time3 = "";
        $time2 = new DateTime($time[$i]);
        $time2 = $time2->format('H:i:s');
        $time3 = new DateTime($time[$j]);
        $time3 = $time3->format('H:i:s');
        if($attend >= $time2 && $attend <= $time3){
          $diff =$time2->diff($time3);
          $cmd = $msg[$cnt].$diff;

          break;
        }else{
        $i +=2;
        $j = $i + 1;
        }
      }else{
        $time2 = new DateTime($time[$cnt]);
        $time2 = $time2->format('H:i:s');
        if($attend >= $time2){
          $cmd = $msg[$cnt];
        }
      }
      //var_dump($cnt);
    }
  }
    //  if($time4[$i] = '09:31:00'){
    //    $msg = "なんで学校にきたの";
    // }else if($row['登校時間'] <= '09:31:00' && $row['登校時間'] >= '10:31:00'){
  //     $msg = "1限遅刻";
  //   }
  //   else if($row['登校時間'] <= '10:32:00' && $row['登校時間'] >= '11:10:00'){
  //     $msg = "2限出席";
  //   }
  //   else if($row['登校時間'] <= '11:11:00' && $row['登校時間'] >= '12:11:00'){
  //     $msg = "2限遅刻";
  //   }
  //   else if($row['登校時間'] <= '13:12:00' && $row['登校時間'] >= '13:40:00'){
  //     $msg = "3限出席";
  //   }
//    else{
//     $msg = "学校やってないよ";
//   }
// }else{
//   $msg = "欠席";
// }
  ?>
    <tr>
    <td><?php print($row['学籍番号']);?>
    <td><?php print($row['名前']);?>
    <td><?php print($row['クラス']);?>
    <td><?=$cmd?>
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