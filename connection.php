<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

define('HOST','localhost');
define('USER','root');
define('PASS','');
define('PRIMARY_DB','status_book');
define('BATCH1_DB','2017_2021');
define('BATCH2_DB','2018_2022');
define('BATCH3_DB','2019_2023');
define('BATCH4_DB','2020_2024');

$primary_db = new mysqli(HOST,USER,PASS,PRIMARY_DB) or die('Connetion error to the database');


?>
