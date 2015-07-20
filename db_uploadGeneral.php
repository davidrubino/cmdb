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

function insertDB($conn, $property_id, $config_id, $str_value, $date_value, $float_value) {
	try {
		$sql = 'insert into property_value
		(property_id, config_id, str_value, date_value, float_value)
		values
		(:property_id, :config_id, :str_value, :date_value, :float_value);';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':property_id' => $property_id, ':config_id' => $config_id, ':str_value' => $str_value, ':date_value' => $date_value, ':float_value' => $float_value));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if ($_POST) {
	if (isset($_POST['generalA'])) {
		for ($i = 0; $i < count($_POST['generalA']); $i++) {
			$conf_id = key($_POST['generalA'][$i]);
			$name = key($_POST['generalA'][$i][$conf_id]);
			$value = current($_POST['generalA'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}

	if (isset($_POST['generalB'])) {
		for ($i = 0; $i < count($_POST['generalB']); $i++) {
			$conf_id = key($_POST['generalB'][$i]);
			$name = key($_POST['generalB'][$i][$conf_id]);
			$value = current($_POST['generalB'][$i][$conf_id]);
			updateDB($DB_con, $value, $name, $conf_id);
		}
	}
}
?>