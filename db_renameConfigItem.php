<?php

include 'db_connect.php';

function renameConfigItem($conn) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	try {
		$sql = 'update config_item
		set name = :name
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql_property = 'update property_value, property
		set property_value.str_value = :value
		where property_value.config_id = :id
		and property_value.property_id = property.id
		and property.name = "hostname"';
		$stmt_property = $conn -> prepare($sql_property);
		$stmt_property -> execute(array(':value' => $name, ':id' => $id));
		$row_property = $stmt_property -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Update successful!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameConfigItem($DB_con);
?>