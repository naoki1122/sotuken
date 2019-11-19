<?php
//$user = 'user';
$user = 'root';
//$password = 'marioff3';
$password='';
// 利用するデータベース
$dbName = 'management';
// MySQLサーバ
//$host = '192.168.1.2';
$host = 'localhost';
// MySQLのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }

   if(isset($_POST['検索'])){
       if(isset($_POST['if']) && $_POST['if'] == "名前"){
        $ifname = $_POST['if'];
        $stmt = $pdo->prepare("select * from management.teacher where 名前 = ?");
        $stmt->execute($ifname);
            }else if(isset($_POST['if']) && $_POST['if'] == "教員番号"){
            $ifname = $_POST['if'];
            $stmt = $pdo->prepare("select * from management.teacher where 教員番号 = ?");
            $stmt->execute($ifname);
       }
    }
//        }
//     }
//       $name = $_POST['name'];
//       $no = $_POST['no'];
//       $password = $_POST['password'];
//       $authority = $_POST['authority'];
      
//   echo '登録完了';
// }
// else{
//     $word = "NO";
// }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>教員情報変更</title>
</head>
<body>
<!--戻るのリンク-->
<a href="teacherlist.html">戻る</a><br>
<H1>教員情報変更</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <select id="input1" name="if" required>
        <option value="" selected>条件を指定してください</option>
        <option value="名前" >名前</option>
        <option value="教員番号" >教員番号</option>
    </select><br>
    <input id="input1" type="text" name="word">
    <input id="button" type="submit" value="検索" name="検索"><br>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post">
    お名前　　　
    <input id="input" type="text" name="name" required autofocus ><br>
    教員番号　　
    <input id="input" type="text" name="no" required ><br>
    パスワード　
    <input id="input" type="password" name="password" ><br>
    権限　　　　
    <select id="input" name="authority" required>
        <option value="" selected>権限を選択してください</option>
        <option value="0">管理者</option>
        <option value="1">一般教員</option>
        <option value="2">アシスタント</option>
    </select><br>
    <input id="button" type="submit" value="変更" name="変更">
    </form>
<!--copyright-->
<footer>copyright チームコリジョン</footer>
</body>
</html>