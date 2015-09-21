<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getServers($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'select map_ci_cabinet.position, config_item.name
		from map_ci_cabinet, config_item
		where map_ci_cabinet.ci_id = config_item.id
		and map_ci_cabinet.cabinet_id = :id';
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