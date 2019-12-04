<?php
//sotukenサーバー用のDB情報
require_once("server_config.php");
//ローカル用のサーバー情報
//require_once("localhost_config.php");

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
  if(isset($_POST['word'])){
    $word = $_POST['word'];
  }
  else{
      $word = "";
  }
  

  if(isset($_POST['検索'])){
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
    $sql = "select * from management.teacher where 名前 = ?";
    var_dump($sql);
        }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
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
    if(isset($_POST['削除'])){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $sql = "delete from management.teacher where 名前 = ? and 教員番号 = ?
                and パスワード = ? and 権限 = ?";
    var_dump($sql);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$no,$password,$authority));
    echo "できた";
    }
    
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//出来てない！！！権限を数値から名前に変えるやつ
// if($authority == 0){
//     $rename = str_replace('0','管理者',$authority)
//         }elseif($authority == 1){
//             $rename = str_replace('1','教員',$authority)
//                 }else{
//                     $rename = str_replace('2','アシスタント',$authority)
// }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>教員削除</title>
</head>
<body>
<!--戻るのリンク-->
<a href="teacher_list.php">戻る</a><br>
<H1>教員削除</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件指定-->
    <select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="教員番号">教員番号</option>
    </select><br>
    <!--検索条件入力-->
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" >
    <!--名前-->お名前　　　
    <input id="input" type="text" readonly value="<?=$name?>" name="name" required><br>
    <!--教員番号-->教員番号　　
    <input id="input" type="text" readonly value="<?=$no?>" name="no" required><br>
    <!--パスワード-->パスワード　
    <input id="input" type="password" readonly value="<?=$password?>" name="password"><br>
    <!--権限-->権限　　　　
    <input id="input" type="text" readonly value="<?=$authority?>" name="authority"><br>
    <input id="button" type="submit" value="削除" name="削除" onclick="return checkupdate()">
</form>
<script>
    function checkdelete(){
        return confirm('本当に削除してもよいですか？\nこの操作は取り消せません。');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>