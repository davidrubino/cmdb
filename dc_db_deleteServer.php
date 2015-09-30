<?php

include 'db_connect.php';

header('Content-Type: application/json');

function deleteServer($conn) {
	$position = $_POST['position'];	
	$id = $_POST['id'];

	try {
		$pre_sql = 'select height from config_item
		where starting_position = :position
		and cabinet_id = :id';
		$pre_stmt = $conn -> prepare($pre_sql);
		$pre_stmt -> execute(array(':position' => $position, ':id' => $id));
		$pre_row = $pre_stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($pre_row);
		
		$sql = 'update config_item
		set starting_position = NULL,
		height = NULL,
		cabinet_id = NULL
		where starting_position = :position
		and cabinet_id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':position' => $position, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

deleteServer($DB_con);
?>