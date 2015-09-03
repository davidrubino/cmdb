<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getTiles($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'select html_row, html_col
		from tile
		where data_center_id = :id
		and grayed_out = 1';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getTiles($DB_con);
?>