<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getCabinetColor($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'select color
		from cabinet
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getCabinetColor($DB_con);
?>