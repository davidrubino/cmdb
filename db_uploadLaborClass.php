<?php

include 'db_connect.php';

function updateDB($conn, $name, $value_type, $tab) {
	try {
		$class_id = $_POST['class_id'];
		
		$sql = 'insert into property
		(name, value_type, tab)
		values
		(:name, :value_type, :tab);';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':value_type' => $value_type, ':tab' => $tab));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql2 = 'insert into map_class_property
		(class_id, prop_id)
		values
		(:class_id, (select id from property
		order by id desc 
		limit 1));';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':class_id' => $class_id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if ($_POST) {
	if (isset($_POST['labor-class'])) {
		$name = $_POST['labor-class'];
		$value_type = $_POST['select-labor-class'];
		$tab = "labor";
		updateDB($DB_con, $name, $value_type, $tab);
	}
}
?>