<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getLevel($conn, $id) {
	try {
		$sql = "
		select parent_id from graph
		where id = :id;
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($row as $i) {
			if ($i['parent_id'] == null) {
				return 1;
			} else {
				return 1 + getLevel($conn, $i['parent_id']);
			}
		}

	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
}

function createGraph($conn) {
	$application_id = $_POST['application_id'];
	
	try {
		$nodes = array();
		$edges = array();
		$count = 0;

		$sql = "
		select id, name, type, parent_id
		from graph
		where application_id = :application_id
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':application_id' => $application_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($row as $i) {
			array_push($nodes, ['id' => $i['id'],
								'group' => $i['type'],
								'label' => $i['name'],
								'level' => getLevel($conn, $i['id'])]);
								
			if ($i['parent_id'] != null) {
				$count++;
				array_push($edges, ['id' => $count, 'from' => $i['parent_id'], 'to' => $i['id']]);
			}
		}

		$root = ['nodes' => $nodes, 'edges' => $edges];
		echo json_encode($root);

	} catch (PDOException $e) {
		echo $e -> getMessage();
	}
}

createGraph($DB_con);
?>