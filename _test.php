<?php
//require_once("php7note\chap13\lib\util.php");

// 文字エンコードの検証
// if (!cken($_POST)){
//   header("Location:{$gobackURL}");
//   exit();
// }

if((!isset($_POST["name"])||($_POST["name"]==="")) && (!isset($_POST["No"])||($_POST["No"]===""))){
  $_POST['name'] = "";
  $_POST['No'] = "";
exit();
}

// データベースユーザ
$user = 'root';
$password = '';
// 利用するデータベース
$dbName = 'management';
// MySQLサーバ
$host = 'localhost';
// MySQLのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>個人情報変更</title>
 <!-- <link href="php7note\chap13\css\style.css" rel="stylesheet">
 テーブル用のスタイルシート
<link href="php7note\chap13\css\tablestyle.css" rel="stylesheet"> -->
</head>
<body>
<div>
<form method="POST" action="search.php">
        <label>名前(漢字)を検索します（部分一致）</label><br>
        <input type="text" name="名前" placeholder="名前（漢字）を入れてください。" autocomplete="off"><br>
        
      <label>学籍番号（部分一致）</label><br>
        <input type="text" name="学籍番号" placeholder="学籍番号を入れてください。" autocomplete="off">

      <!-- <select name='Kurasu'>
        <option value=''></option>
        <option value='2N1'>2N1</option>
        <option value='2N2'>2N2</option>
      </select> -->
      <input type="submit" value="検索" >
  </form>
  
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
    // echo "入力した名前  ";
    // var_dump($name);echo "<br>";
    // echo "入力した学籍番号  ";
    // var_dump($no);echo "<br>";
    // echo "<br>";
    // var_dump($sql);echo "<br>";
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
        foreach ($result as $row){?>
    <input type="text"value="<?php $row['名前'] ?>">
     <?php echo "名前に「{$name}」が含まれているレコード<br>";
      echo "学籍番号に「{$no}」が含まれているレコード";
        }
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

