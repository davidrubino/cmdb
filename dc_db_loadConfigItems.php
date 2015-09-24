<?php

include 'db_connect.php';

header('Content-Type: application/json');

function loadConfigItems($conn) {
	try {
		$sql = "select id, name
		from config_item
		where cabinet_id is null;";

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