<?php

include 'db_connect.php';

$array_ci = array();

function getConfigItems($conn, $class_id) {
	global $array_ci;

	try {
		$sql_ci = 'select id from config_item
		where class_id = :class_id';
		$stmt_ci = $conn -> prepare($sql_ci);
		$stmt_ci -> execute(array(':class_id' => $class_id));
		$row_ci = $stmt_ci -> fetchAll(PDO::FETCH_ASSOC);

		if (!empty($row_ci)) {
			foreach ($row_ci as $i) {
				array_push($array_ci, $i['id']);
			}
		}

		$sql_parent = 'select id from class
		where parent_id = :class_id';
		$stmt_parent = $conn -> prepare($sql_parent);
		$stmt_parent -> execute(array(':class_id' => $class_id));
		$row_parent = $stmt_parent -> fetchAll(PDO::FETCH_ASSOC);

		if (empty($row_parent)) {
			return $array_ci;
		} else {
			foreach ($row_parent as $i) {
				return getConfigItems($conn, $i['id']);
			}
		}

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

function createProperty($conn) {
	try {
		$name = $_POST['property-name'];
		$value_type = $_POST['property-type'];
		$class_id = $_POST['class_id'];
		$tab = $_POST['tab'];

		$sql1 = 'insert into property
		 (name, value_type, tab)
		 values
		 (:name, :value_type, :tab);';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':name' => $name, ':value_type' => $value_type, ':tab' => $tab));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);

		echo "Property created!";
		echo "<br>";

		$sql2 = 'insert into map_class_property
		 (class_id, prop_id)
		 values
		 (:class_id, (select id from property
		 order by id desc
		 limit 1));';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':class_id' => $class_id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);

		echo "Mapping complete!";
		echo "<br>";

		$iterate = getConfigItems($conn, $class_id);

		foreach ($iterate as $row) {
			$sql3 = 'insert into property_value
			 (property_id, config_id, str_value, date_value, float_value)
			 values
			 ((select id from property
			 order by id desc
			 limit 1), :config_item, NULL, NULL, NULL);';
			$stmt3 = $conn -> prepare($sql3);
			$stmt3 -> execute(array(':config_item' => $row));
			$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);
		}

		echo "Values inserted!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createProperty($DB_con);
?>