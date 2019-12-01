<!--
//sotukenサーバー用のDB情報
//require_once("server_config.php");
//ローカル用のサーバー情報
// require_once("server_config.php");
// $gobackURL = "teacher_update.php";
// if(isset($_POST['word'])){
//     $word = $_POST['word'];
//   }
//   else{
//       $word = "";
//   }

// try {
//     $pdo = new PDO(DSN, DB_USER, DB_PASS);
//     // プリペアドステートメントのエミュレーションを無効にする
//     $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//     // 例外がスローされる設定にする
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
// }catch (Exception $e) {
//     echo '<span class="error">エラーがありました。</span><br>';
//     echo $e->getMessage();
//   }

//   $name = "";
//   $no = "";
//   $password = "";
//   $authority = "";
//   $sql = "";

//   if(isset($_POST['検索'])){
//     if(isset($_POST['word']) && $_POST['mode'] == "名前"){
//         $mode = "名前";
//         $word = $_POST['word'];
//         setcookie("word",$_POST['word']);
//         setcookie("mode",$_POST['mode']);
//         $sql = "select * from management.teacher where 名前 = ?";
//         var_dump($sql);
//     }else if(isset($_POST['word']) && $_POST['mode'] == "教員番号"){
//         $mode = "教員番号";
//         $word = $_POST['word'];
//         setcookie("word",$_POST['word']);
//         setcookie("mode",$_POST['mode']);
//         $sql = "select * from management.teacher where 教員番号 = ?";
//         var_dump($sql);
//     }else{
//         header("Location:{$gobackURL}");
//     }

//     $stmt = $pdo->prepare($sql);
//     $stmt->execute([$word]);
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     foreach ($result as $row){
//        $name  = $row["名前"];
//        $no = $row["教員番号"];
//        $password = $row["パスワード"];
//        $authority = $row["権限"];
//     }
// }else{
//     $cmd = "なし";
// }

// if(isset($_POST['変更'])){
//     $mode = $_COOKIE['mode'];
//     var_dump($mode);
//     if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "名前"){
//         $name = $_POST['name'];
//         $no = $_POST['no'];
//         $password = $_POST['password'];
//         $authority = $_POST['authority'];
//         $word = $_COOKIE['word'];
//         $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
//                 パスワード = ?,権限 = ? where 名前 = ?";
//     }
//     else if(isset($_POST['name'],$_POST['no'],$_POST['password'],$_POST['authority']) && $mode == "教員番号"){
//         $name = $_POST['name'];
//         $no = $_POST['no'];
//         $password = $_POST['password'];
//         $authority = $_POST['authority'];
//         $word = $_COOKIE['word'];
//         var_dump($mode);
//         $sql = "update management.teacher set 名前 = ?,教員番号 = ?,
//                 パスワード = ?,権限 = ? where 教員番号 = ?";
//     }
//     echo $sql;
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute(array($name,$no,$password,$authority,$word));
//     echo "できた";
//     }
    
    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
-->

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <!-- <link href="contents.css" rel="stylesheet" media="all"> -->
    <link href="test.css" rel="stylesheet" media="all">
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
<form action="" method="post" >
<div  id="formmain">
<dl>
    <!--名前-->
    <dt><span style="color:red;">*必須 </span><label for="name">お名前<label></dt>
    <dd><input id="name" type="text" name="name" value="<?=$name?>" required></dd>
    <!-- フリガナ -->
    <dt><span style="color:red;">*必須 </span><label for="name2">フリガナ<label></dt>
    <dd><input id="name2" type="text" name="name2" value="" required placeholder="例：サトウタロウ"></dd>
    <!--学籍番号-->
    <dt><span style="color:red;">*必須 </span><label for="no">学籍番号<label></dt>
    <dd><input id="no" type="text" name="no" value="" required placeholder="例：x00n000"></dd>
    <!-- 学年 -->
    <dt><span style="color:red;">*必須 </span><label for="class">学年<label></dt>
    <dd><input id="class" type="text" name="class" value=""　required></dd>
    <!-- クラス -->
    <dt><span style="color:red;">*必須 </span><label for="class2">クラス<label></dt>
    <dd><input id="class2" type="text" name="class2" value=""　required></dd>
    <!--パスワード-->
    <dt><span style="color:red;">*必須 </span><label for="password">パスワード<label></dt>
    <dd><input id="password" type="password" name="password" value="" required placeholder="例：abedefg"></dd>
    <!--メアド-->
    <dt><span style="color:red;">*必須 </span><label for="mail">メールアドレス<label></dt>
    <dd><input id="mail" type="email" name="mail" value="" required placeholder="例：Example@xxx.com"></dd>
    <!--電話番号-->
    <dt><span style="color:red;">*必須 </span><label for="tel">電話番号<label></dt>
    <dd><input id="tel" type="tel" name="tel" value="" required placeholder="ハイフンなし"></dd>
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
</form>
</div>
<script>
    function checkupdate(){
        return confirm('この内容で登録変更してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>