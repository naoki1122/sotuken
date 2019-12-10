<?php
     $id = $POST['word'];
try{
$dbh = new PDO("mysql:host=localhost;dbname=management","root","");
//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 静的プレースホルダを指定
//$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//実行したいSQL文を記述
// $stmt = $dbh->prepare("select * from student where $id");
// $stmt->setFetchMode(PDO::FETCH_ASSOC);
$sql = "SELECT * from student WHERE ?";
$stmt = $dbh->prepare($sql);
$stmt->execute(array($id));
$stmt->execute();
$rows = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
$rows[]=$row;
$id=array("student"=>$rows);
}
//接続成功ならjson形式で吐き出します
echo json_encode($id, JSON_UNESCAPED_UNICODE);
} catch(PDOException $e){
echo "失敗時のメッセージ（なくていもいい）";
echo $e->getMessage();
}
$dbh = null;
?>



