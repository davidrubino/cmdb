<?php

include 'db_connect.php';

function createClass($conn) {
	$class_id = $_POST['class_id'];
	$parent_id = $_POST['parent_id'];

	try {
		$sql1 = 'insert into config_item
		(id, name, class_id)
		select max(id) + 1, "New node", :class_id from config_item';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':class_id' => $class_id));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);

		$sql2 = 'select property.id from property, map_class_property
		where property.id = map_class_property.prop_id
		and (map_class_property.class_id = :class_id
		or map_class_property.class_id = :parent_id)';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':class_id' => $class_id, ':parent_id' => $parent_id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($row2 as $row) {
			$sql3 = 'INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(:property_id, (select id from config_item
			order by id desc 
			limit 1), NULL, NULL, NULL);';
			$stmt3 = $conn -> prepare($sql3);
			$stmt3 -> execute(array(':property_id' => $row[id]));
			$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);
		}

		echo "Config item created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createClass($DB_con);
?>