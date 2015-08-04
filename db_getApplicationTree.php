<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getApplicationTree($conn) {
	//$id = $_POST['id'];
	$id = 1000;
	
	try {
		$sql = 'select application.name
		from application
		where application.id = :id';
		
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($row);
		
	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getApplicationTree($DB_con);

?>