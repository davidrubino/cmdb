<?php

include 'db_connect.php';

header('Content-Type: application/json');

function loadValues($conn) {
	try {
		$nodes = array();
		
		$sql = 'select * from data_center';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($row as $i) {
			array_push($nodes, ['id' => $i['id'], 'text' => $i['name'], 'type' => 'file']);
		}
		
		$root = ['id' => -1, 'text' => 'Data Centers', 'children' => $nodes, 'state' => ['opened' => false]];
		
		echo json_encode($root);
		
	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
}

loadValues($DB_con);
?>