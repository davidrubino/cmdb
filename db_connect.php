<?php

function connect($servername, $username, $password, $dbname) {
	$conn = null;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Connection failed: " . $e -> getMessage();
	}
	return $conn;
}

function closeConnection($conn) {
	$conn = null;
	return $conn;
}

?>