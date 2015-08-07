<?php

include 'db_connect.php';

header('Content-Type: application/json');

function loadConfigItems($conn) {
	try {
		$sql = "
		select name from config_item;
		";

		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($row);

	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
}

loadConfigItems($DB_con);
?>