<!DOCTYPE html>
<html eng=ja>

<head>
    <<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    >
    <link href="CSS_ver 1.00.css" rel="stylesheet" media="all">
    <title>とりあえず管理ページ</title>
</head>

<body>
    <div style="padding : 20px 10px 1px;">
        <input type="text" id="dat">
    </div>
    <script type="text/javascript" src="today.js">
    </script>
    <h1>学生管理アプリケーション</h1>
    <p class="user">ユーザー名 朝賀</p>

    <?php
      $dsn = 'mysql:dbname=test;host=localhost;charset=utf8';
      $user = 'root';
      $password = '';
      try{
        $dbh = new PDO($dsn, $user, $password);
      
        $sql = 'select * from member';
?>

<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>名前</th>
  <th>ふりがな</th>
  <th>クラス</th>
  <th>メールアドレス</th>
  </tr>
  
    <section id="print"><?php foreach ($dbh->query($sql) as $row){?>
          <tr>
            <td><?php echo ($row['No']);?></td>
            <td><?php echo ($row['name']);?></td>
            <td><?php echo ($row['hurigana']);?></td>
            <td><?php echo ($row['kurasu']);?></td>
            <td><?php echo ($row['mail']);?></td>
      </tr>
      <?php
    }
    ?>
    </table>
  </div>
    </section>
    <p class="logout">ログアウト</p>
    <P class="option">設定　登録</P>
    <a href= "subject.html" >今日の日課</a>

      
        <?php
      }catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
      }

      $dbh = null;
      ?>
</body>
</html>