<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getCabinets($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'select tile.html_row, tile.html_col, cabinet.color
		from tile, cabinet
		where cabinet.tile_id = tile.id
		and tile.data_center_id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getCabinets($DB_con);
?>