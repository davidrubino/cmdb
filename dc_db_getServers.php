<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getServers($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'select starting_position, name, height
		from config_item
		where cabinet_id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getServers($DB_con);
?>