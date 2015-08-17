<?php

include 'db_connect.php';

function updateDB($conn) {
	$conf_id = $_POST['id'];
	$name = $_POST['name'];
	$value = $_POST['value'];

	try {
		$sql = 'update property_value, property
		set	property_value.str_value = if(property.value_type = "string", :value1, null),
			property_value.date_value = if(property.value_type = "date", :value2, null),
			property_value.float_value = if(property.value_type = "float", :value3, null)
		where property_value.property_id = property.id
		and property_value.config_id = :conf_id
		and property.name = :name';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':value1' => $value, ':value2' => $value, ':value3' => $value, ':name' => $name, ':conf_id' => $conf_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Update successful!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

updateDB($DB_con);
?>