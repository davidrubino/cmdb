<?php

include 'db_connect.php';

function updateDB($conn, $name, $value_type, $tab) {
	try {
		$class_id = $_POST['class_id'];
		
		$sql1 = 'insert into property
		(name, value_type, tab)
		values
		(:name, :value_type, :tab);';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':name' => $name, ':value_type' => $value_type, ':tab' => $tab));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql2 = 'insert into map_class_property
		(class_id, prop_id)
		values
		(:class_id, (select id from property
		order by id desc 
		limit 1));';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':class_id' => $class_id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql3 = 'select config_item.id from config_item
		where config_item.class_id = :class_id';
		$stmt3 = $conn -> prepare($sql3);
		$stmt3 -> execute(array(':class_id' => $class_id));
		$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($row3 as $row) {
			$sql4 = 'insert into property_value
		(property_id, config_id, str_value, date_value, float_value)
		values
		((select id from property
		order by id desc 
		limit 1), :config_item, NULL, NULL, NULL);';
			$stmt4 = $conn -> prepare($sql4);
			$stmt4 -> execute(array(':config_item' => $row[id]));
			$row4 = $stmt4 -> fetchAll(PDO::FETCH_ASSOC);
		}
		
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if ($_POST) {
	if (isset($_POST['financial-subclass'])) {
		$name = $_POST['financial-subclass'];
		$value_type = $_POST['select-financial-subclass'];
		$tab = "financial";
		updateDB($DB_con, $name, $value_type, $tab);
	}
}
?>