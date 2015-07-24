<?php

include 'db_connect.php';

function renameFile($conn) {
	//$value = "lazy";
	//$id = 1000;
	$value = $_POST['value'];
	$id = $_POST['id'];
	
	try {
		$sql = 'update property_value, property
		set property_value.str_value = :value
		where property_value.config_id = :id
		and property_value.property_id = property.id
		and property.name = "hostname"';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':value' => $value, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameFile($DB_con);

?>