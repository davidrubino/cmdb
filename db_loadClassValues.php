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

function getValues($conn) {
	$id = $_POST['id'];
	$tab = $_POST['tab'];

	try {
		$iterate = array();

		$sql_firstParent = 'select class_id from config_item
		where id = :id';
		$stmt_firstParent = $conn -> prepare($sql_firstParent);
		$stmt_firstParent -> execute(array(':id' => $id));
		$row_firstParent = $stmt_firstParent -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($row_firstParent as $i) {
			$iterate = getParents($conn, $i['class_id']);
		}

		$result = array();

		foreach ($iterate as $row) {
			$sql_name = 'select name from class
			where id = :class_id';
			$stmt_name = $conn -> prepare($sql_name);
			$stmt_name -> execute(array(':class_id' => $row));
			$row_name = $stmt_name -> fetchAll(PDO::FETCH_ASSOC);

			$sql_values = 'select property.name,
			if(property.value_type = "string", property_value.str_value, if(property.value_type = "date", property_value.date_value, property_value.float_value)) as value
			from property_value, config_item, property, map_class_property, class
			where property_value.config_id = config_item.id
			and config_item.id = :id
			and property_value.property_id = property.id
			and property.tab = :tab
			and property.id = map_class_property.prop_id
			and map_class_property.class_id = class.id
			and class.id = :parent_id';
			$stmt_values = $conn -> prepare($sql_values);
			$stmt_values -> execute(array(':id' => $id, ':parent_id' => $row, ':tab' => $tab));
			$row_values = $stmt_values -> fetchAll(PDO::FETCH_ASSOC);
			
			array_push($result, ['title' => $row_name, 'content' => $row_values]);
		}

		echo json_encode($result);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getValues($DB_con);
?>