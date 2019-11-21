<?php
//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
require_once("localhost_config.php");

if(isset($_POST['word'])){
    $word = $_POST['word'];
  }
  else{
      $word = "";
  }

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

  $name = "";
  $no = "";
  $password = "";
  $authority = "";
  $sql = "";
  $cookie = setcookie("word",$word);
  
  

  if(isset($_POST['検索'])){
    if(isset($_POST['word']) && $_POST['if'] == "名前"){
        $if = "名前";
        $word = $_POST['word'];
    $sql = "select * from management.teacher where 名前 = ?";
    var_dump($sql);
    }else if(isset($_POST['word']) && $_POST['if'] == "教員番号"){
        $if = "教員番号";
        $word = $_POST['word'];
        $sql = "select * from management.teacher where 教員番号 = ?";
        var_dump($sql);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$word]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row){
       $name  = $row["名前"];
       $no = $row["教員番号"];
       $password = $row["パスワード"];
       $authority = $row["権限"];
    }
}else{
    $cmd = "なし";
}
var_dump($cookie);
if(isset($_POST['変更'])){
    if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $if = "名前"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $sql = "update management.teacher set 名前 = '${name}' and 教員番号 = '${no}'
                and パスワード = '${password}' and 権限 = ${authority}
                where 名前 = ${cookie}";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    echo "できた";
    }
    
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
    <!--検索条件指定-->
    <select id="input1" name="if" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="教員番号">教員番号</option>
    </select><br>
    <!--検索条件入力-->
    <input id="input1" type="text" name="word" autofocus autocomplete="no">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->お名前　　　
    <input id="input" type="text" value="<?=$name?>"name="name" required ><br>
    <!--教員番号-->教員番号　　
    <input id="input" type="text" value="<?=$no?>" name="no" required ><br>
    <!--パスワード-->パスワード　
    <input id="input" type="password" value="<?=$password?>" name="password" ><br>
    <!--権限選択-->権限　　　　
    <select id="input" name="authority" value="<?=$authority?>" required>
        <option value="" selected>権限を選択し直してください</option>
        <option value="">管理者</option>
        <option value="1">一般教員</option>
        <option value="2">アシスタント</option>
    </select><br>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
</form>
<script>
    function checkupdate(){
        return confirm('この内容で登録してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>