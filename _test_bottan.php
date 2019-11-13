<?php
// require_once("php7note\chap13\lib\util.php");
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
<!-- <link href="php7note\chap13\css\style.css" rel="stylesheet">
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet"> -->
</head>
<body>
<div>
<?php
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "データベース{$dbName}に接続しました。", "<br>";
    // SQL文を作る（全レコード）
    $sql = "SELECT * FROM number";
    // プリペアドステートメントを作る
    $stm = $pdo->prepare($sql);
    // SQL文を実行する
    $stm->execute();
    // 結果の取得（連想配列で返す）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
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
      echo "<tr>";
      echo "<td>", $row['No'], "</td>";
      echo "</tr>";
  }
    echo "</tbody>";
    echo "</table>";
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
    exit();
  }
  ?>

  <!-- 入力フォームを作る -->
  <form method="POST" action="_test.php">
        <label>学籍番号を入力（読み取る）例18n000</label><br>
        <input type="text" name="No" placeholder="バーコード" autocomplete="on"><br>
        
      <input type="submit" value="検索" >
  </form>
</div>
</body>
</html>