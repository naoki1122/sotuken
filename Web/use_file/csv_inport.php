<?php
setlocale(LC_ALL, 'ja_JP.UTF-8');
 
$file = 'csv_inport.csv';
$data = file_get_contents($file);
$data = mb_convert_encoding($data, 'UTF-8', 'auto');
$temp = tmpfile();
$csv  = array();
 
fwrite($temp, $data);
rewind($temp);
 
while (($data = fgetcsv($temp, 0, ",")) !== FALSE) {
    $csv[] = $data;
}
fclose($temp);
 
var_dump($csv);