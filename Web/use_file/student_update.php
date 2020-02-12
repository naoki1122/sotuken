<?php
session_start();
//sotukenサーバー用のDB情報
require_once "server_config.php";
require_once "lib.php";

$gobackURL = "student_list.php";
$tbl= "management.student";

// セッションの代入
if(empty($_SESSION['名前'])&&empty($_SESSION['権限'])){
    header("Location:{$gobackURL}");
  }else{
  $session_name = $_SESSION['名前'];
  $session_level = $_SESSION['権限'];
  }
  // MySQLデータベースに接続する
  $pdo = dbcon();

  // 変数代入
if(isset($_POST['WORD'])) $word = $_POST['WORD'];
if(isset($_POST['NAME']))$name = $_POST['NAME'];
if(isset($_POST['HURI']))$huri = $_POST['HURI'];
if(isset($_POST['S_NO']))$s_no = $_POST['S_NO'];
if(isset($_POST['PASSWD']))$pass = $_POST['PASSWD'];
if(isset($_POST['YEAR']))$year = $_POST['YEAR'];
if(isset($_POST['CLASS']))$class = $_POST['CLASS'];
if(isset($_POST['SUBJECT']))$subject = $_POST['SUBJECT'];
if(isset($_POST['MAIL']))$mail = $_POST['MAIL'];
if(isset($_POST['TEL']))$tel = $_POST['TEL'];
if(isset($_POST['TRAIN1']))$train1 = $_POST['TRAIN1'];
if(isset($_POST['TRAIN2']))$train2 = $_POST['TRAIN2'];
if(isset($_POST['TRAIN3']))$train3 = $_POST['TRAIN3'];
// なければnull
if(empty($_POST['WORD'])) $word = null;
if(empty($_POST['NAME']))$name = null;
if(empty($_POST['HURI']))$huri = null;
if(empty($_POST['S_NO']))$s_no = null;
if(empty($_POST['PASSWD']))$pass = null;
if(empty($_POST['YEAR']))$year = null;
if(empty($_POST['CLASS']))$class = null;
if(empty($_POST['SUBJECT']))$subject = null;  
if(empty($_POST['MAIL']))$mail = null;
if(empty($_POST['TEL']))$tel = null;
if(empty($_POST['TRAIN1']))$train1 = null;
if(empty($_POST['TRAIN2']))$train2 = null;
if(empty($_POST['TRAIN3']))$train3 = null;

  // 検索
  if(isset($_POST['検索'])){
    // 名前検索
    if(!empty($word) && $_POST['MODE'] == "名前"){
        $mode = "名前";
      setcookie("word",$_POST['WORD']);
      setcookie("mode",$_POST['MODE']);
      $sql = "select 学籍番号,名前,フリガナ,学年,クラス,学科,メールアドレス,電話番号,パスワード,路線1,路線2,路線3 from ${tbl} where 名前 = :word";
    // 学籍番号検索
}else if(!empty($word) && $_POST['MODE'] == "学籍番号"){
    $mode = "教員番号";
      setcookie("word",$_POST['WORD']);
      setcookie("mode",$_POST['MODE']);
      $sql = "select 学籍番号,名前,フリガナ,学年,クラス,学科,メールアドレス,電話番号,パスワード,路線1,路線2,路線3 from ${tbl} where 学籍番号 = :word";
  }
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(":word", $word, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row){
    $s_no = $row["学籍番号"];
    $name  = $row["名前"];
    $huri  = $row["フリガナ"];
    $year = $row["学年"];
    $class  = $row["クラス"];
    $subject  = $row["学科"];
    $mail  = $row["メールアドレス"];
    $tel = $row["電話番号"];
    $pass = $row["パスワード"];
    $train1 = $row["路線1"];
    $train2 = $row["路線2"];
    $train3 = $row["路線3"];
    }
}
if(isset($_POST['変更']) && (isset($_POST))){
    $mode = $_COOKIE['mode'];
    $word = $_COOKIE['word'];
    $sql = "UPDATE ${tbl} SET ";

    if(!empty($s_no)){
        $sql .= "学籍番号 = :s_no ";
    }
    if(!empty($name)){
        if(!empty($s_no)){$sql .= ", ";}
        $sql .= "名前 = :name ";
    }
    if(!empty($huri)){
        if((!empty($s_no))||(!empty($name))){$sql .= ", ";}
        $sql .= "フリガナ = :huri ";
    }
    if(!empty($year)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))){$sql .= ", ";}
        $sql .= "学年 = :year ";
    }
    if(!empty($class)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))){$sql .= ", ";}
        $sql .= "クラス = :class ";
    }
    if(!empty($subject)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))){$sql .= ", ";}
        $sql .= "学科 = :subject ";
    }
    if(!empty($mail)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))){$sql .= ", ";}
        $sql .= "メールアドレス = :mail ";
    }
    if(!empty($tel)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))||(!empty($mail))){$sql .= ", ";}
        $sql .= "電話番号 = :tel ";
    }
    if(!empty($pass)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))||(!empty($mail))||(!empty($tel))){$sql .= ", ";}
        $sql .= "パスワード = :pass ";
    }
    if(!empty($train1)){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))||(!empty($mail))||(!empty($tel))||(!empty($pass))){$sql .= ", ";}
        $sql .= "路線1 = :train1 ";
    }
    if((!empty($train2))){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))||(!empty($mail))||(!empty($tel))||(!empty($pass))||(!empty($train1))){$sql .= ", ";}
        if(empty($train1)){
            $train1 = $train2;
            $train2 ="";
            $sql .= "路線1 = :train1 ";
        }elseif(!empty($train1)){$sql .= "路線2 = :train2 ";}
    }
    if((!empty($train3))){
        if((!empty($s_no))||(!empty($name))||(!empty($huri))||(!empty($year))||(!empty($class))||(!empty($subject))||(!empty($mail))||(!empty($tel))||(!empty($pass))||(!empty($train1))||(!empty($train3))){$sql .= ", ";}
        if((empty($train1))&&(empty($train2))){
            $train1 = $train3;
            $train3 ="";
            $sql .= "路線1 = :train1 ";
        }elseif((!empty($train1))&&(empty($train2))){
            $train2 = $train3;
            $train3 = "";
            $sql .= "路線2 = :train2 ";
        }elseif((empty($train1))&&(!empty($train2))){
            $train1 = $train2;
            $train2 = $train3;
            $train3 = "";
            $sql .= "路線2 = :train2 ";
        }elseif((!empty($train1))&&(!empty($train2))){
            $sql .= "路線3 = :train3 ";
        }
    }
    if($mode == "名前"){$sql .= "WHERE 名前 = :word";}
    else if($mode == "学籍番号"){$sql .= "WHERE 学籍番号 = :word";}
    $stmt = $pdo->prepare($sql);
    if(!empty($s_no)) $stmt->bindValue(":s_no", $s_no, PDO::PARAM_STR);
    $stmt->bindValue(":word", $word, PDO::PARAM_STR);
    if(!empty($name)) $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    if(!empty($huri)) $stmt->bindValue(":huri", $huri, PDO::PARAM_STR);
    if(!empty($year)) $stmt->bindValue(":year", $year, PDO::PARAM_STR);
    if(!empty($class)) $stmt->bindValue(":class", $class, PDO::PARAM_STR);
    if(!empty($subject)) $stmt->bindValue(":subject", $subject, PDO::PARAM_STR);
    if(!empty($mail)) $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
    if(!empty($tel)) $stmt->bindValue(":tel", $tel, PDO::PARAM_STR);
    if(!empty($pass)) $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    if(!empty($train1)) $stmt->bindValue(":train1", $train1, PDO::PARAM_STR);
    if(!empty($train2)) $stmt->bindValue(":train2", $train2, PDO::PARAM_STR);
    if(!empty($train3)) $stmt->bindValue(":train3", $train3, PDO::PARAM_STR);
    $name = "";
    $huri = "";
    $s_no = "";
    $pass = "";
    $year = "";
    $class = "";
    $subject = "";
    $mail = "";
    $tel = "";
    $train1 = "";
    $train2 = "";
    $train3 = "";
    $stmt->execute();

    }
    
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <link href="form.css" rel="stylesheet" media="all">
    <title>生徒情報変更</title>
</head>
<body id="wrap">
<header id="header">
<!--戻るのリンク-->
<button type=“button” id="back-button" onclick="location.href='student_list.php'">戻る</button><br>
<p> </p><br>
<!-- ログイン中の名前 -->
<p>ようこそ<?=$session_name?>さん</p>
<!-- ログアウトボタン -->
<button type=“button” id="logout-button" onclick="location.href='logout.php'">ログアウト</button>
<!-- タイトル -->
<H1>生徒情報変更</H1>
</header>
<!--検索フォーム-->
<form id ="form_search" action="" method="post">
<!--検索条件指定-->
<ul>
    <li><select id="input1" name="MODE" required >
        <option value="" selected>条件を指定してください</option>
        <option value="名前">名前</option>
        <option value="学籍番号">学籍番号</option>
    </select></li>
    <!--検索条件入力-->
    <input id="input1" type="text" name="WORD" autofocus autocomplete="off">
    <!--検索ボタン-->
    <input id="button" type="submit" value="検索" name="検索">
</ul>
</form>
<!--入力フォーム-->
<form id="formmain" action="" method="post">
    <section id="input_form">
    <ul>
    <!--名前-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">名前</span>
    <input class="inputbox" type="text" value="<?=$name?>" name="NAME" required  placeholder="例：山田太郎"></lavel></li>
    <!--フリガナ-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">フリガナ</span>
    <input class="inputbox" type="text" value="<?=$huri?>" name="HURI" pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" title="フリガナはカタカナで入力してください。" required placeholder="例：ヤマダタロウ"></lavel></li>
    <!--学籍番号-->
    <li></lavel><span style="color: red">*必須  </span><span class="item">学籍番号</span>
    <input class="inputbox" type="text" value="<?=$s_no?>" name="S_NO" pattern="(^x\d{2}[a-z]\d{3}$)" title="学籍番号はxを含む正規の形で入力してください。" required placeholder="例：x00n000"></lavel></li>
    <!--パスワード-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">パスワード</span>
    <input class="inputbox" type="password" value="<?=$pass?>" name="PASSWD" required placeholder="abcd1234"></lavel></li>
    <!--学年-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学年</span>
    <input class="inputbox" type="number" value="<?=$year?>" name="YEAR" min="1" max="4" value="1" required placeholder="1"></lavel></li>
    <!--クラス-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">クラス</span>
    <input class="inputbox" type="number" value="<?=$class?>" name="CLASS" min="1" max="4" value="1" required placeholder="1"></lavel></li>
    <!--学科-->
    <li><lavel><span style="color: red">*必須  </span><span class="item">学科</span>
    <select class="inputbox" value="<?=$subject?>" name="SUBJECT">
    <?php if(empty($subject)){echo '<option value="" selected>学科を選択してください</option>';}
          if(!empty($subject)){
            echo '<option value="" selected>選択しない場合はここ</option>';
            echo '<option value="'.$subject.'" selected>'.$subject.'</option>';}
   ?>
        <option value="ITエンジニア科4年制">ITエンジニア科4年制</option>
        <option value="ITエンジニア科3年制">ITエンジニア科3年制</option>
        <option value="情報処理科">情報処理科</option>
        <option value="情報ネットワーク科">情報ネットワーク科</option>
        <option value="WEBクリエーター科">WEBクリエーター科</option>
        <option value="こども学科">こども学科</option>
    </select></lavel></li>
    <!--メールアドレス-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">メールアドレス</span>
    <input class="inputbox" type="email" value="<?=$mail?>" name="MAIL"></lavel></li>
    <!--電話番号-->
    <li><lavel><span style="color: black">*任意  </span><span class="item">電話番号</span>
    <input class="inputbox" type="number" value="<?=$tel?>" name="TEL" placeholder="ハイフンなし"></lavel></li>
    <!-- 使用路線1 -->
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" value="<?=$train1?>" name="TRAIN1" >
    <?php if(empty($train1)){echo '<option value="" selected>路線(1路線目)を選んでください</option>';}
          if(!empty($train1)){
            echo '<option value="" selected>使用路線がない場合はここ</option>';
              echo '<option value="'.$train1.'" selected>'.$train1.'</option>';}
   ?>
        <option value="京成本線">京成本線</option>
        <option value="京成千葉線">京成千葉線</option>
        <option value="新京成">新京成</option>
        <option value="芝山鉄道">芝山鉄道</option>
        <option value="東武アーバンパークライン">東武アーバンパークライン</option>
        <option value="常総線">常総線</option>
        <option value="総武線快速">総武線各停</option>
        <option value="総武線各停">総武線快速</option>
        <option value="外房線">内房線</option>
        <option value="内房線">外房線</option>
        <option value="成田線">成田線</option>
        <option value="常磐線">常磐線各停</option>
        <option value="常磐線">常磐線快速</option>
    </select></lavel></li>
    <!-- 使用路線2 -->
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" value="<?=$train2?>" name="TRAIN2" >
    <?php if(empty($train2)){echo '<option value="" selected>路線(2路線目)を選んでください</option>';}
          if(!empty($train2)){
            echo '<option value="" selected>使用路線がない場合はここ</option>';
              echo '<option value="'.$train2.'" selected>'.$train2.'</option>';}
   ?>
        <option value="京成本線">京成本線</option>
        <option value="京成千葉線">京成千葉線</option>
        <option value="新京成">新京成</option>
        <option value="芝山鉄道">芝山鉄道</option>
        <option value="東武アーバンパークライン">東武アーバンパークライン</option>
        <option value="常総線">常総線</option>
        <option value="総武線快速">総武線各停</option>
        <option value="総武線各停">総武線快速</option>
        <option value="外房線">内房線</option>
        <option value="内房線">外房線</option>
        <option value="成田線">成田線</option>
        <option value="常磐線">常磐線各停</option>
        <option value="常磐線">常磐線快速</option>
    </select></lavel></li>
    <!-- 使用路線1 -->
    <li><lavel><span style="color: black">*任意  </span><span class="item">使用路線</span>
    <select class="inputbox" value="<?=$train3?>" name="TRAIN3" >
    <?php if(empty($train3)){echo '<option value="" selected>路線(3路線目)を選んでください</option>';}
          if(!empty($train3)){
            echo '<option value="" selected>使用路線がない場合はここ</option>';
              echo '<option value="'.$train3.'" selected>'.$train3.'</option>';}
   ?>
        <option value="京成本線">京成本線</option>
        <option value="京成千葉線">京成千葉線</option>
        <option value="新京成">新京成</option>
        <option value="芝山鉄道">芝山鉄道</option>
        <option value="東武アーバンパークライン">東武アーバンパークライン</option>
        <option value="常総線">常総線</option>
        <option value="総武線快速">総武線各停</option>
        <option value="総武線各停">総武線快速</option>
        <option value="外房線">内房線</option>
        <option value="内房線">外房線</option>
        <option value="成田線">成田線</option>
        <option value="常磐線">常磐線各停</option>
        <option value="常磐線">常磐線快速</option>
    </select></lavel></li>
</ul>
    <!-- 変更ボタン -->
    <input id="button" type="submit" value="変更" name="変更"onclick="return checkupdate()">
    </section>
</form>
<script>
    function checkupdate(){
        return confirm('この内容で登録変更してもよろしいですか？');
    }
</script>
<!--copyright-->
<footer>copyright© チームコリジョン</footer>
</body>
</html>