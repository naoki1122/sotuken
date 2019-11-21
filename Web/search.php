<?php
//require_once("php7note\chap13\lib\util.php");
$gobackURL = "index_search.php";

// 文字エンコードの検証
// if (!cken($_POST)){
//   header("Location:{$gobackURL}");
//   exit();
// }

// nameが未設定、空のときはエラー
if (empty($_POST)){
  
  header("Location:index_search.php");
  exit();
} else if((!isset($_POST["名前"])||($_POST["名前"]==="")) && (!isset($_POST["学籍番号"])||($_POST["学籍番号"]===""))){
  header("Location:{$gobackURL}");
exit();
}

// データベースユーザ
//sotukenサーバー用のDB情報
require_once("server_config.php");
//ローカル用のサーバー情報
//require_once("localhost_config.php");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>名前検索</title>
<!-- <link href="php7note\chap13\css\style.css" rel="stylesheet">
     テーブル用のスタイルシート 
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet"> -->
</head>
<body>
<div>
  <?php
  $name = $_POST["名前"];
  $no = $_POST['学籍番号'];
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL文を作る
    if((!empty($_POST['学籍番号'])) and (!empty($_POST['名前']))){
      $sql_add = " WHERE 名前 LIKE '%".$_POST['名前']."%' and 学籍番号 LIKE '%".$_POST['学籍番号']."%'";   
    }
    elseif(!empty($_POST['名前'])){
      $sql_add = " WHERE 名前 LIKE '%".$_POST['名前']."%'";
    }
    elseif(!empty($_POST['学籍番号'])){
      $sql_add = " WHERE 学籍番号 LIKE '%".$_POST['学籍番号']."%'";
    }
    $sql = "SELECT * FROM student".$sql_add;
    // プリペアドステートメントを作る
    $stm = $pdo->prepare($sql);
    // プレースホルダに値をバインドする
    //$stm->bindValue(':name', "%{$name}%", PDO::PARAM_STR);
    // SQL文を実行する
    $stm->execute();
    // echo "入力した名前  ";
    // var_dump($name);echo "<br>";
    // echo "入力した学籍番号  ";
    // var_dump($no);echo "<br>";
    // echo "<br>";
    // var_dump($sql);echo "<br>";
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      echo "名前に「{$name}」が含まれているレコード<br>";
      echo "学籍番号に「{$no}」が含まれているレコード";
      // テーブルのタイトル行
      echo "<table>";
      echo "<thead><tr>";
      echo "<th>", "学籍番号", "</th>";
      echo "<th>", "学科", "</th>";
      echo "<th>", "学年", "</th>";
      echo "<th>", "クラス", "</th>";
      echo "<th>", "名前", "</th>";
      echo "<th>", "フリガナ", "</th>";
      echo "<th>", "メールアドレス", "</th>";
      echo "<th>", "学籍番号", "</th>";
      echo "</tr></thead>";
      // 値を取り出して行に表示する
      echo "<tbody>";
      foreach ($result as $row){
        // １行ずつテーブルに入れる
        echo "<tr>";
        echo "<td>", $row['学籍番号'], "</td>";
        echo "<td>", $row['学科'], "</td>";
        echo "<td>", $row['学年'], "</td>";
        echo "<td>", $row['クラス'], "</td>";
        echo "<td>", $row['名前'], "</td>";
        echo "<td>", $row['フリガナ'], "</td>";
        echo "<td>", $row['メールアドレス'], "</td>";
        echo "<td>", $row['電話番号'], "</td>";
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
