<?php
//require_once("php7note\chap13\lib\util.php"); 
$gobackURL = "_test_bottan.php";

// 文字エンコードの検証
// if (!cken($_POST)){
//   header("Location:{$gobackURL}");
//   exit();
// }

// nameが未設定、空のときはエラー
if (empty($_POST)){
  
  header("Location:_test_bottan.php");
  exit();
} else if((!isset($_POST["No"])||($_POST["No"]===""))){
  header("Location:{$gobackURL}");
exit();
}

// データベースユーザ
$user = 'root';
$password = '';
// 利用するデータベース
$dbName = 'test';
// MySQLサーバ
$host = 'localhost';
// MySQLのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
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
  $no = $_POST['No'];
  $timestamp = '';
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL文を作る
    if(!empty($_POST['No'])){
        $sql = "SELECT * FROM number where No =(:no)";
        $stm = $pdo->prepare($sql);
        // プレースホルダに値をバインドする
        $stm->bindValue(':no', "{$no}", PDO::PARAM_STR);
        // SQL文を実行する
        $stm->execute();
      // 結果の取得（連想配列で受け取る）
                 $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                 if(count($result)>0){ 
                   $timestamp = new DateTime();
                   $timestamp = $timestamp->format('Y年m月d日H時i分s秒');
                   $sql = "insert into number(No,time) value('".$no."','".$timestamp."')";
                   var_dump($sql);
                   //$stm->bindValue(':no', "{$no}", PDO::PARAM_STR);
                   $stm = $pdo->prepare($sql);
                   $stm->execute();
                   echo "登録完了";
                   var_dump($timestamp);
         }
          echo "学籍番号「{$no}」<br>";
          // テーブルのタイトル行
          echo "<table>";
          echo "<thead><tr>";
          echo "<th>", "学籍番号", "</th>";
          echo "<th>", "名前", "</th>";
          echo "</tr></thead>";
          // 値を取り出して行に表示する
          echo "<tbody>";
          foreach ($result as $row){
            // １行ずつテーブルに入れる
            echo "<tr>";
            echo "<td>", $row['No'], "</td>";
            echo "</tr>";
          }
          echo "</tbody>";
          echo "</table>";
        }else{
          echo "検索結果0件";
        }
    }
    // プリペアドステートメントを作る
   catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>
