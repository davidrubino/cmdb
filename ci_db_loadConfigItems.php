<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getConfigItems($conn) {	
	try {
		$sql = 'select name
		from config_item';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getConfigItems($DB_con);
?>