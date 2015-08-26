<?php

include 'db_connect.php';

function deleteProperty($conn) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	try {
		$sql1 = 'delete from property_value
		where exists (
		    select property.id from property, map_class_property
		    where property.id = property_value.property_id
		    and property.name = :name
		    and property.id = map_class_property.prop_id
    		and map_class_property.class_id = :id
		    )';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':name' => $name, ':id' => $id));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);

		$sql2 = 'delete from map_class_property
		where exists (
		    select property.id from property
		    where property.id = map_class_property.prop_id
		    and property.name = :name
		    and map_class_property.class_id = :id
		    )';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':name' => $name, ':id' => $id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);

		$sql3 = 'delete from property
		where not exists (
            select map_class_property.id from map_class_property
        	where property.id = map_class_property.prop_id)';
		$stmt3 = $conn -> prepare($sql3);
		$stmt3 -> execute();
		$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);

		echo "Item(s) successfully removed!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteProperty($DB_con);
?>