<?php
// セッションの開始
session_start();

$touroku = htmlspecialchars( $_POST[ 'touroku' ], ENT_QUOTES, 'UTF-8' );
$day = new DateTime();
$now1 = $day->format('Ymdi');
echo $now1;
 
$diff = date_diff($touroku, $now1);
var_dump ($diff);

if($touroku == $now1){
    echo "一緒";
}
else{
    echo "違う";
}
?>