<?php
require_once("localhost_config.php");
$word = $_POST['word']; 
list($id,$name) = explode(",",$word);

echo $id;
echo $name;

try {
    $pdo = new PDO(DSN,DB_USER,DB_PASS);
    $stmt = $pdo->prepare('select * from student where 名前 = ?');
    $stmt->execute($name);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
  }
  //名前がDB内に存在しているか確認
  if (!isset($row['名前'])) {
    echo '名前が間違っています。';
    return ;
  }
  //パスワード確認後sessionにメールアドレスを渡す　password_verify
  if ($id==$row['id']) {
    session_regenerate_id(true); //session_idを新しく生成し、置き換える
    $_SESSION['名前'] = $row['名前'];
    echo 'ログインしました';
      exit;
  } else {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
  }

?>