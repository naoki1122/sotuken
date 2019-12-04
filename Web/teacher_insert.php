<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
//ローカル用のサーバー情報
//require_once "localhost_config.php";
 require_once "lib.php";

 $pdo = dbcon();

 if(isset($_POST['登録'])){
   if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority'])){
       $name = $_POST['name'];
       $no = $_POST['no'];
       $authority = $_POST['authority'];
       if(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,15}+\z/i', $_POST['password'])) {
         $password = $_POST['password'];
       }else{
         echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
         return false;
       }
       $sql = "INSERT INTO management.teacher(名前,教員番号,パスワード,権限) VALUES (?,?,?,?)";
       $stmt = $pdo->prepare($sql);
       $stmt->execute(array($name, $no,$password,$authority));
       echo '登録完了';
         
       }
       ?>
       <meta http-equiv="refresh" content=" 2; url=teacher_insert.php">
       <?php
 }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="contents.css" rel="stylesheet" media="all">
    <title>教員登録</title>
</head>
<body>
<!--戻るのリンク-->
<a href="teacher_list.php">戻る</a><br>
<H1>教員登録</H1><br>
<!--入力フォーム-->
<form id="formmain" action="" method="post" onSubmit="return checksubmit()">
    <!--名前-->
    <span class="font1">*必須</span>　お名前　　　
    <input id="input" type="text" name="name" required autofocus placeholder="例：山田太郎"><br>
    <!--教員番号-->
    <span class="font1">*必須</span>　教員番号　　
    <input id="input" type="text" name="no" required placeholder="例：t00x000"><br>
    <!--パスワード-->
    <span class="font1">*必須</span>　パスワード　
    <input id="input" type="password" name="password" required placeholder="例：abedefg"><br>
    <!--権限-->
    <span class="font1">*必須</span>　権限　　　　
    <select id="input" name="authority" required>
        <option value="" selected>権限を選択してください</option>
        <option value="0">管理者</option>
        <option value="1">一般教員</option>
        <option value="2">アシスタント</option>
    </select><br>
    <!--登録ボタン-->
    <input id="button" type="submit" value="登録" name="登録" >
    <!--リセットボタン-->
    <input id="button" type="reset" value="リセット" onclick="return resetcheck()">
</form>
<!--確認ポップアップ用javascript-->
<script>
    //リセット確認
    function resetcheck(){
        return confirm('リセットしてもよろしいですか？');
    }
    //登録確認
    function checksubmit(){
        return confirm('この内容で登録してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>