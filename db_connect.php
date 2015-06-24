<?php

session_start();

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "america76";
$DB_name = "test";

try {
	$DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
	$DB_con -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$DB_con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo $e -> getMessage();
}

include_once 'user.php';
$user = new USER($DB_con);
?>