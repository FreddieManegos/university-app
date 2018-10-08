<?php 
ob_start();
//session_start();
$host = "host=127.0.0.1"; 
$port = "port=5432";
$dbname = "dbname=UniversityApp";
$credentials = "user=postgres password=09193692079369";
$db = pg_connect( "$host $port $dbname $credentials" ); //Important! Connection for the PHP and Postgresql
if(!$db)
	echo 'error';
else
	//echo 'success';
?>