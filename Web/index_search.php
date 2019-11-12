
<?php
require_once("php7note\chap13\lib\util.php");
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
<link href="php7note\chap13\css\style.css" rel="stylesheet">
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet">
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
    $sql = "SELECT * FROM member ORDER BY No ASC";
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
    echo "<th>", "ふりがな", "</th>";
    echo "<th>", "クラス", "</th>";
    echo "<th>", "メールアドレス", "</th>";
    echo "</tr></thead>";
  // 値を取り出して行に表示する
    echo "<tbody>";
    foreach ($result as $row){
      // １行ずつテーブルに入れる
      echo "<tr>";
      echo "<tr>";
      echo "<td>", es($row['No']), "</td>";
      echo "<td>", es($row['name']), "</td>";
      echo "<td>", es($row['hurigana']), "</td>";
      echo "<td>", es($row['kurasu']), "</td>";
      echo "<td>", es($row['mail']), "</td>";
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
  <form method="POST" action="search.php">
        <label>名前(漢字)を検索します（部分一致）</label><br>
        <input type="text" name="name" placeholder="名前（漢字）を入れてください。" autocomplete="off"><br>
        
      <label>学籍番号（部分一致）</label><br>
        <input type="text" name="No" placeholder="学籍番号を入れてください。" autocomplete="off">

      <!-- <select name='Kurasu'>
        <option value=''></option>
        <option value='2N1'>2N1</option>
        <option value='2N2'>2N2</option>
      </select> -->
      <input type="submit" value="検索" >
  </form>
</div>
</body>
</html>