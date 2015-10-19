<?php

include 'db_connect.php';

header('Content-Type: application/json');

$array_parents = array();

function getParents($conn, $id) {
	global $array_parents;

	try {
		$sql = 'select parent_id, name from folder
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $i) {
			array_push($array_parents, ['id' => $id, 'name' => $i['name']]);
		}

		foreach ($row as $i) {
			if ($i['parent_id'] == NULL) {
				return $array_parents;
			} else {
				return getParents($conn, $i['parent_id']);
			}
		}

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

function getPopUpContent($conn) {
	//$name = $_POST['name'];
	$name = 'lazy';

	try {
		$iterate = array();
		$result = array();
		$app = array();

		$sql = 'select application.name, application.folder_id
		from application, graph, config_item
		where application.id = graph.application_id
		and graph.config_item_id = config_item.id
		and config_item.name = :name';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($row as $i) {
			$iterate = getParents($conn, $i['folder_id']);
			array_push($app, ['parents' => $iterate, 'application' => $i['name']]);
		}
		
		echo json_encode($app);
		
	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getPopUpContent($DB_con);
?>