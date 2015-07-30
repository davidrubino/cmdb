<?php

include 'db_connect.php';

header('Content-Type: application/json');

function loadValues($conn) {
	try {
		$id = $_POST['id'];

		$nodes = array();
		$sql = 'select * from folder where parent_id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql_ci = 'select * from application where folder_id = :id';
		$stmt_ci = $conn -> prepare($sql_ci);
		$stmt_ci -> execute(array(':id' => $id));
		$row_ci = $stmt_ci -> fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($row as $i) {
			array_push($nodes, ['id' => $i['id'], 'text' => $i['name'], 'type' => 'folder', 'children' => true, 'state' => ['opened' => false]]);
		}
		
		foreach ($row_ci as $i_ci) {
			array_push($nodes, ['id' => $i_ci['id'], 'text' => $i_ci['name'], 'type' => 'file']);
		}
		
		echo json_encode($nodes);

	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
}

loadValues($DB_con);
?>