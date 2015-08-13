<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveProperties($conn) {
	$id = $_POST['id'];
	$parent_id = $_POST['parent_id'];
	$tab = $_POST['tab'];

	try {
		$result = array();
		
		$sql_parent = 'select name from class
		where id = :parent_id';
		$stmt_parent = $conn -> prepare($sql_parent);
		$stmt_parent -> execute(array(':parent_id' => $parent_id));
		$row_parent = $stmt_parent -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql = 'select property.name,
		if(property.value_type = "string", property_value.str_value, if(property.value_type = "date", property_value.date_value, property_value.float_value)) as value
		from property_value, config_item, property, map_class_property, class
		where property_value.config_id = config_item.id
		and config_item.id = :id
		and property_value.property_id = property.id
		and property.id = map_class_property.prop_id
		and property.tab = :tab
		and map_class_property.class_id = class.id
		and class.id = :parent_id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id, ':parent_id' => $parent_id, ':tab' => $tab));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		array_push($result, ['title' => $row_parent, 'content' => $row]);
		echo json_encode($result);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

retrieveProperties($DB_con);
?>