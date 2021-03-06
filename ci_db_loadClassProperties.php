<?php

include 'db_connect.php';

header('Content-Type: application/json');

function getProperties($conn) {
	$tab = $_POST['tab'];
	$class_id = $_POST['class_id'];
	
	try {
		$result = array();
		
		$sql_title = 'select name from class
		where id = :class_id';
		$stmt_title = $conn -> prepare($sql_title);
		$stmt_title -> execute(array(':class_id' => $class_id));
		$row_title = $stmt_title -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql = 'select property.name, property.value_type
		from property, map_class_property, class
		where property.tab = :tab
		and property.id = map_class_property.prop_id
		and map_class_property.class_id = class.id
		and class.id = :class_id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':tab' => $tab, ':class_id' => $class_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		array_push($result, ['title' => $row_title, 'content' => $row]);
		echo json_encode($result);

	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'error while loading']);
	}
}

getProperties($DB_con);
?>