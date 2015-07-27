<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveProperties($conn) {
	$class_id = $_POST['class_id'];
	
	try {
		$sql = 'select property.name, property.tab, property.value_type
		from property, map_class_property, class
		where property.id = map_class_property.prop_id
		and map_class_property.class_id = class.id
		and class.id = :class_id';

		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':class_id' => $class_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($row);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

retrieveProperties($DB_con);
?>