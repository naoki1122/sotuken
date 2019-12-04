<?php
//sotukenサーバー用のDB情報
require_once "server_config.php";
//ローカル用のサーバー情報
//require_once "localhost_config.php";
require_once "lib.php";

$gobackURL = "student_update.php";
if(isset($_POST['word'])){
    $word = $_POST['word'];
  }
  else{
      $word = "";
  }

$pdo = dbcon();

  $name="";$name2="";$no="";
  $class="";$class2="";$password="";$tel="";
  $train1="";$train2="";$train3="";$mail="";$subject="";
  
  $authority;
  $sql;

  if(isset($_POST['検索'])){
    if(isset($_POST['word']) && $_POST['mode'] == "名前"){
        $mode = "名前";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select * from management.student where 名前 = ?";
        var_dump($sql);
    }else if(isset($_POST['word']) && $_POST['mode'] == "学籍番号"){
        $mode = "学籍番号";
        $word = $_POST['word'];
        setcookie("word",$_POST['word']);
        setcookie("mode",$_POST['mode']);
        $sql = "select * from management.student where 学籍番号 = ?";
        var_dump($sql);
    }else{
        header("Location:{$gobackURL}");
    }
}
if(isset($_POST['変更'])){
    $mode = $_COOKIE['mode'];
    var_dump($mode);
    if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "名前"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $word = $_COOKIE['word'];
        $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
                パスワード = ?,権限 = ? where 名前 = ?";
    }
    else if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "教員番号"){
        $name = $_POST['name'];
        $no = $_POST['no'];
        $password = $_POST['password'];
        $authority = $_POST['authority'];
        $word = $_COOKIE['word'];
        var_dump($mode);
        $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
                パスワード = ?,権限 = ? where 教員番号 = ?";
    }
    echo $sql;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$no,$password,$authority,$word));
    echo "できた";
    }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link href="contents.css" rel="stylesheet" media="all"> -->
    <!-- <link href="test.css" rel="stylesheet" media="all"> -->
    <title>生徒情報変更</title>
</head>
<body>
<!--戻るのリンク-->
<a href="student_list.html">戻る</a><br>
<H1>生徒情報変更</H1><br>
<!--検索フォーム-->
<form id ="search" action="" method="post">
    <!--検索条件指定-->
    <select id="input1" name="mode" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="学籍番号">学籍番号</option>
    </select><br>
    <!--検索条件入力-->
    <input id="input1" type="text" name="word" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索"><br>
</form><br>
<!--入力フォーム-->
<form action="" method="post">
    <!--名前-->
    <div class="form-group row">
    <label class="col-sm-2 control-label"><span style="color:red;">*必須 </span>お名前</label>
    <div class="col-sm-10">
        <input class="form-control" type="text" name="name" value="<?=$name?>" required>
    </div>
</div>
    <!-- フリガナ -->
<div class="form-group row">
    <label class="col-sm-2 control-label"><span style="color:red;">*必須 </span>フリガナ</label>
    <div class="col-sm-10">
        <input class="form-control" type="text" name="name2" value="<?=$name2?>" required placeholder="例：サトウタロウ">
    </div>
</div>
    <!--学籍番号-->
<div class="form-group row">
    <label class="col-sm-2 control-label"><span style="color:red;">*必須 </span>学籍番号</label>
    <div class="col-sm-10">
        <input class="form-control" type="text" name="no" value="<?=$no?>" required placeholder="例：x00n000">
    </div>
</div>
    <!-- 学年 -->
    <dt><span style="color:red;">*必須 </span><label for="class">学年<label></dt>
    <dd><input id="class" type="text" name="class" value="<?=$class?>"　required></dd>
    <!-- クラス -->
    <dt><span style="color:red;">*必須 </span><label for="class2">クラス<label></dt>
    <dd><input id="class2" type="text" name="class2" value="<?=$class2?>"　required></dd>
    <!--パスワード-->
    <dt><span style="color:red;">*必須 </span><label for="password">パスワード<label></dt>
    <dd><input id="password" type="password" name="password" value="<?=$password?>" required placeholder="例：abedefg"></dd>
    <!--メアド-->
    <dt><span style="color:red;">*必須 </span><label for="mail">メールアドレス<label></dt>
    <dd><input id="mail" type="email" name="mail" value="<?=$mail?>" required placeholder="例：Example@xxx.com"></dd>
    <!--電話番号-->
    <dt><span style="color:red;">*必須 </span><label for="tel">電話番号<label></dt>
    <dd><input id="tel" type="tel" name="tel" value="<?=$tel?>" required placeholder="ハイフンなし"></dd>
    <!--学科-->
    <dt><label for="subject">学科<label></dt>
    <dd><select id="subject" name="subject" required>
        <option value="" selected>学科を選択し直してください</option>
        <option value="0">ITエンジニア科4年制</option>
        <option value="1">ITエンジニア化3年制</option>
        <option value="2">情報処理科</option>
        <option value="3">情報ネットワーク科</option>
        <option value="4">WEBクリエーター科</option>
        <option value="5">こども学科</option>
    </select></dd>
    <dt><label for="train1">使用路線<label></dt>
    <dd><select id="train1" name="train1" >
        <option value="" selected>使用する路線(1路線目)を選んでください</option>
        <option value="京成本線1">京成本線</option>
        <option value="京成千葉線">京成千葉線</option>
        <option value="新京成">新京成</option>
        <option value="総武線快速">総武線快速</option>
        <option value="総武線各停">総武線各停</option>
        <option value="東部アーバンパークライン">東部アーバンパークライン</option>
        <option value="外房線">外房線</option>
        <option value="内房線">内房線</option>
        <option value="常磐線">常磐線</option>
        <option value="常総線">常総線</option>
    </select></dd>
    <dt><label for="train2">使用路線2<label></dt>
    <dd><select id="train2" name="train2">
        <option value="" selected>使用する路線(2路線目)を選んでください</option>
        <option value="京成本線-2">京成本線</option>
        <option value="京成千葉線-2">京成千葉線</option>
        <option value="新京成-2">新京成</option>
        <option value="総武線快速-2">総武線快速</option>
        <option value="総武線各停-2">総武線各停</option>
        <option value="東部アーバンパークライン-2">東部アーバンパークライン</option>
        <option value="外房線-2">外房線</option>
        <option value="内房線-2">内房線</option>
        <option value="常磐線-2">常磐線</option>
        <option value="常総線-2">常総線</option>
    </select></dd>
    <dt><label for="train3">使用路線3<label></dt>
    <dd><select id="train3" name="train3">
        <option value="" selected>使用する路線(3路線目)を選んでください</option>
        <option value="京成本線-3">京成本線</option>
        <option value="京成千葉線-3">京成千葉線</option>
        <option value="新京成-3">新京成</option>
        <option value="総武線快速-3">総武線快速</option>
        <option value="総武線各停-3">総武線各停</option>
        <option value="東武アーバンパークライン-3">東部アーバンパークライン</option>
        <option value="外房線-3">外房線</option>
        <option value="内房線-3">内房線</option>
        <option value="常磐線-3">常磐線</option>
        <option value="常総線-3">常総線</option>
    </select></dd>
</dl>
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
</div>
</form>
<script>
    function checkupdate(){
        return confirm('この内容で登録変更してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>