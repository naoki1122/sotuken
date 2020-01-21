<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";

$gobackURL = "start_attend.html";

if (empty($_POST)){
  header("Location:start_attend.html");
  exit();
} else if((!isset($_POST["学籍番号"])||($_POST["学籍番号"]===""))){
  header("Location:{$gobackURL}");
exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>名前検索</title>
</head>
<body>
<div>
  <?php
  $no = $_POST['学籍番号'];
  $timestamp = '';
  $timestamp2 = '';

  //MySQLデータベースに接続する
  $pdo = dbcon();
  
    // SQL文を作る
    if(isset($_POST['学籍番号'])){
      $no = $_POST['学籍番号'];
      $sql = "SELECT * FROM student where 学籍番号 = ?";
      $stm = $pdo->prepare($sql);
      $stm->execute(array($no));
      // 結果の取得（連想配列で受け取る）
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          if(count($result)>0){
          $sql = "SELECT * FROM attend where 学籍番号 = ? and 登校日 = ?";
          // タイムゾーンを日本に設定
          date_default_timezone_set('Asia/Tokyo');
          // 時刻を取得
          $timestamp = new DateTime();
          $timestamp2 = $timestamp->format('Y-m-d');
          $timestamp = $timestamp->format('H:i:s');
          // SQL文を実行する
          $stm = $pdo->prepare($sql);
          $stm->execute(array($no,$timestamp2));
          // 結果の取得（連想配列で受け取る）
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)==0){
            $sql = "insert into attend(学籍番号,登校日,登校時間) value(?,?,?)";
            $stm = $pdo->prepare($sql);
            $stm->execute(array($no,$timestamp2,$timestamp));
            echo "登録完了";
            ?>
            <meta http-equiv="refresh" content=" 1; url=start_attend.html">
            <?php
            }else{
              header("Location:{$gobackURL}");
              ?>
              <meta http-equiv="refresh" content=" 1; url=start_attend.html">
              <?php
            }
            }else{
              header("Location:{$gobackURL}");
      ?>
      <meta http-equiv="refresh" content=" 1; url=start_attend.html">
      <?php
     }
     }else{
      header("Location:{$gobackURL}");
      ?>
      <meta http-equiv="refresh" content=" 1; url=start_attend.html">
      <?php
     }
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>
