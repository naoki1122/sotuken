<?php
//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
require_once("localhost_config.php");

//require_once("php7note\chap13\lib\util.php"); 

$gobackURL = "start_attend.html";

// 文字エンコードの検証
// if (!cken($_POST)){
//   header("Location:{$gobackURL}");
//   exit();
// }
// nameが未設定、空のときはエラー
if (empty($_POST)){
  header("Location:start_attend.html");
  exit();
} else if((!isset($_POST["学籍番号"])||($_POST["学籍番号"]===""))){
  header("Location:{$gobackURL}");
exit();
}
// データベースユーザ
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>名前検索</title>
<!-- <link href="php7note\chap13\css\style.css" rel="stylesheet"> -->
<!-- テーブル用のスタイルシート -->
<!-- <link href="php7note\chap13\css\tablestyle.css" rel="stylesheet"> -->
</head>
<body>
<div>
  <?php
  $no = $_POST['学籍番号'];
  $timestamp = '';
  $timestamp2 = '';
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO(DSN, DB_USER, DB_PASS);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
    // SQL文を作る
    if(isset($_POST['学籍番号'])){
      $no = $_POST['学籍番号'];
      // タイムゾーンを日本に設定
      date_default_timezone_set('Asia/Tokyo');
      // 時刻を取得
      $timestamp = new DateTime();
      $timestamp2 = $timestamp->format('Y-m-d');
      $timestamp = $timestamp->format('H:i:s');
      $sql = "SELECT * FROM attend where 学籍番号 = ? and 登校日 = ?";
      // SQL文を実行する
      $stm = $pdo->prepare($sql);
      $stm->execute(array($no,$timestamp2));
      // 結果の取得（連想配列で受け取る）
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row){
        echo $row['学籍番号'],$row['登校日'],$row['登校時間'];
     }
                  if(count($result)<0){
                    $sql = "insert into attend(学籍番号,登校日,登校時間) value(?,?,?)";
                    //var_dump($sql);
                    $stm = $pdo->prepare($sql);
                    $stm->execute(array($no,$timestamp2,$timestamp));
                    echo "登録完了";
                    var_dump($timestamp2,$stm);
                   }
                   else{
                    foreach ($result as $row){
                      echo $row['学籍番号'],$row['登校日'],$row['登校時間'];
                   }
                  }
                }else{
                  header("Location:{$gobackURL}");
        }
    // プリペアドステートメントを作る
     
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>
