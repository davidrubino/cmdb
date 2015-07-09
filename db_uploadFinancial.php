<?php

include 'db_connect.php';

function updateDB($conn, $value, $name, $conf_id) {
	try {
		$sql = 'update property_value, property
		set	property_value.str_value = if(property_value.str_value is null, null, :value1),
			property_value.date_value = if(property_value.date_value is null, null, :value2),
			property_value.float_value = if(property_value.float_value is null, null, :value3)
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

if ($_GET) {
	if (isset($_GET['financialA'])) {
		for ($i = 0; $i < count($_GET['financialA']); $i++) {
			$conf_id = key($_GET['financialA'][$i]);
			$name = key($_GET['financialA'][$i][$conf_id]);
			$value = current($_GET['financialA'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}

	if (isset($_GET['financialB'])) {
		for ($i = 0; $i < count($_GET['financialB']); $i++) {
			$conf_id = key($_GET['financialB'][$i]);
			$name = key($_GET['financialB'][$i][$conf_id]);
			$value = current($_GET['financialB'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}
}
?>