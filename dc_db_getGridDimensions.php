<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getGridDimensions($conn) {
	$id = $_POST['id'];
	
	try {
		$sql = 'select count_rows, count_columns
		from data_center
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getGridDimensions($DB_con);
?>