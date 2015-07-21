<?php

include 'db_connect.php';

function updateDB($conn, $value, $name, $conf_id) {
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

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if ($_POST) {
	if (isset($_POST['financialA'])) {
		for ($i = 0; $i < count($_POST['financialA']); $i++) {
			$conf_id = key($_POST['financialA'][$i]);
			$name = key($_POST['financialA'][$i][$conf_id]);
			$value = current($_POST['financialA'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}

	if (isset($_POST['financialB'])) {
		for ($i = 0; $i < count($_POST['financialB']); $i++) {
			$conf_id = key($_POST['financialB'][$i]);
			$name = key($_POST['financialB'][$i][$conf_id]);
			$value = current($_POST['financialB'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}
}
?>