<?php

include 'db_connect.php';

function deleteServer($conn) {
	$position = $_POST['position'];	
	$id = $_POST['id'];

	try {
		$sql = 'delete from map_ci_cabinet
		where position = :position
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