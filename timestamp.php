<?php
	// UNIX TIMESTAMPを取得
	$timestamp = time() ;
	// 曜日の配列
	$weekday = array( '日' , '月' , '火' , '水' , '木' , '金' , '土' ) ;
	var_dump($timestamp);
	// date()で日時を出力
	echo date( "Y年m月j日 " .$weekday[ date('w') ]."曜日 A H時i分s秒" , $timestamp ) ;

	$week = array("日", "月", "火", "水", "木", "金", "土");
$datetime = date_create();
$w = (int)date_format($datetime, 'w');
echo $week[$w];
?>