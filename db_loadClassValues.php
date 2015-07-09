<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveProperties($conn) {
	$id = $_POST['id'];
	$grandparent_id = $_POST['grandparent_id'];

	try {
		$sql = 'select property.name, property.tab,
		ifnull(property_value.str_value, ifnull(property_value.date_value, property_value.float_value)) as value
		from property_value, config_item, property, map_class_property, class
		where property_value.config_id = config_item.id
		and config_item.id = :id
		and property_value.property_id = property.id
		and property.id = map_class_property.prop_id
		and map_class_property.class_id = class.id and class.id = :grandparent_id';

		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id, ':grandparent_id' => $grandparent_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

retrieveProperties($DB_con);
?>