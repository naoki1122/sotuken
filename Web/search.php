<?php
require_once("php7note\chap13\lib\util.php");
$gobackURL = "index_search.php";

// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (empty($_POST)){
  
  header("Location:index_search.php");
  exit();
} else if((!isset($_POST["name"])||($_POST["name"]==="")) && (!isset($_POST["No"])||($_POST["No"]===""))){
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
<link href="php7note\chap13\css\style.css" rel="stylesheet">
<!-- テーブル用のスタイルシート -->
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet">
</head>
<body>
<div>
  <?php
  $name = $_POST["name"];
  $no = $_POST['No'];
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL文を作る
    if((!empty($_POST['name'])) and (!empty($_POST['No']))){
      $sql_add = " WHERE name LIKE '%".$_POST['name']."%' and No LIKE '%".$_POST['No']."%'";   
    }
    elseif(!empty($_POST['name'])){
      $sql_add = " WHERE name LIKE '%".$_POST['name']."%'";
    }
    elseif(!empty($_POST['No'])){
      $sql_add = " WHERE No LIKE '%".$_POST['No']."%'";
    }
    $sql = "SELECT * FROM member".$sql_add;
    // プリペアドステートメントを作る
    $stm = $pdo->prepare($sql);
    // プレースホルダに値をバインドする
    //$stm->bindValue(':name', "%{$name}%", PDO::PARAM_STR);
    // SQL文を実行する
    $stm->execute();
    echo "入力した名前  ";
    var_dump($name);echo "<br>";
    echo "入力した学籍番号  ";
    var_dump($no);echo "<br>";
    echo "<br>";
    var_dump($sql);echo "<br>";
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      echo "名前に「{$name}」が含まれているレコード<br>";
      echo "学籍番号に「{$no}」が含まれているレコード";
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
        echo "<td>", es($row['No']), "</td>";
        echo "<td>", es($row['name']), "</td>";
        echo "<td>", es($row['hurigana']), "</td>";
        echo "<td>", es($row['kurasu']), "</td>";
        echo "<td>", es($row['mail']), "</td>";
        echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>";
    } else {
      echo "名前に「{$name}」は見つかりませんでした。<br>";
      
      echo "学籍番号に「{$no}」は見つかりませんでした。";
    }
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
</body>
</html>
