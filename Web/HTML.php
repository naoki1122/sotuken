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
      $dsn = 'mysql:dbname=management;host=localhost;charset=utf8';
      $user = 'root';
      $password = '';
      try{
        $dbh = new PDO($dsn, $user, $password);
      
        $sql = 'select * from student';
?>

<div id='style table'>
<table border="1">
  <tr>
  <th>学籍番号</th>
  <th>学科</th>
  <th>学年</th>
  <th>クラス</th>
  <th>名前</th>
  <th>フリガナ</th>
  <th>メールアドレス</th>
  <th>電話番号</th>
  </tr>
  
    <section id="print"><?php foreach ($dbh->query($sql) as $row){?>
          <tr>
            <td><?php echo ($row['学籍番号']);?></td>
            <td><?php echo ($row['学科']);?></td>
            <td><?php echo ($row['学年']);?></td>
            <td><?php echo ($row['クラス']);?></td>
            <td><?php echo ($row['名前']);?></td>
            <td><?php echo ($row['フリガナ']);?></td>
            <td><?php echo ($row['メールアドレス']);?></td>
            <td><?php echo ($row['電話番号']);?></td>
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