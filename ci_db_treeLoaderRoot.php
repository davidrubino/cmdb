<?php

include 'db_connect.php';

header('Content-Type: application/json');

function loadRootValues($conn) {
	try {
		$nodes = array();
		$sql = 'select * from class where parent_id is null;';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($row as $i) {
			array_push($nodes, ['id' => $i['id'], 'text' => $i['name'], 'type' => 'folder', 'children' => true, 'state' => ['opened' => false]]);
		}
		
		$root = ['id' => -1, 'text' => 'Root', 'children' => $nodes, 'state' => ['opened' => false]];
		
		echo json_encode($root);

	} catch (PDOException $e) {
		echo json_encode(['id' => -1, 'text' => 'Root']);
	}
}

loadRootValues($DB_con);
?>