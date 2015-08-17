<?php

include 'db_connect.php';

header('Content-Type: application/json');

$array_parents = array();

function getParents($conn, $id) {
	global $array_parents;

	try {
		$sql = 'select parent_id from class
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		array_push($array_parents, $id);

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

function getProperties($conn) {
	$tab = $_POST['tab'];
	$id = $_POST['id'];

	try {
		$sql_title = 'select class_id from config_item
		where id = :id';
		$stmt_title = $conn -> prepare($sql_title);
		$stmt_title -> execute(array(':id' => $id));
		$row_title = $stmt_title -> fetchAll(PDO::FETCH_ASSOC);

		foreach($row_title as $i) {
			$iterate = getParents($conn, $i['class_id']);
		}
		$result = array();

		foreach ($iterate as $row) {
			$sql_class = 'select name from class
			where id = :class_id';
			$stmt_class = $conn -> prepare($sql_class);
			$stmt_class -> execute(array(':class_id' => $row));
			$row_class = $stmt_class -> fetchAll(PDO::FETCH_ASSOC);

			$sql_values = 'select property.name, property.value_type
			from property, map_class_property, class
			where property.tab = :tab
			and property.id = map_class_property.prop_id
			and map_class_property.class_id = class.id
			and class.id = :class_id';
			$stmt_values = $conn -> prepare($sql_values);
			$stmt_values -> execute(array(':tab' => $tab, ':class_id' => $row));
			$row_values = $stmt_values -> fetchAll(PDO::FETCH_ASSOC);

			array_push($result, ['title' => $row_class, 'content' => $row_values]);
		}

		echo json_encode($result);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getProperties($DB_con);
?>