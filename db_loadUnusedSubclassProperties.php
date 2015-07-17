<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveProperties($conn) {
	//$tab = "labor";
	//$class_id = 1;
	//$config_item_id = 1000;
	$tab = $_POST['tab'];
	$class_id = $_POST['class_id'];
	$config_item_id = $_POST['config_item_id'];

	try {
		$sql = 'select property.id, property.name
		from property, map_class_property, class, config_item
		where property.tab = :tab
		and property.id = map_class_property.prop_id
		and map_class_property.class_id = class.id
		and class.id = :class_id
		and class.id = config_item.class_id
		and config_item.id = :config_item_id
		and not exists
		( select * from property_value
		where property.id = property_value.property_id
		and property_value.config_id = config_item.id )';

		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':tab' => $tab, ':class_id' => $class_id, ':config_item_id' => $config_item_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

retrieveProperties($DB_con);
?>