<?php

include 'db_connect.php';

function removeProperty($conn) {
	//$name = "distribution";
	$name = $_POST['name'];
	
	try {
		$sql1 = 'delete from property_value
		where exists (
		    select property.id from property
		    where property.id = property_value.property_id
		    and property.name = :name
		    )';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':name' => $name));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql2 = 'delete from map_class_property
		where exists (
		    select property.id from property
		    where property.id = map_class_property.prop_id
		    and property.name = :name
		    )';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':name' => $name));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql3 = 'delete from property
		where name = :name';
		$stmt3 = $conn -> prepare($sql3);
		$stmt3 -> execute(array(':name' => $name));
		$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Item(s) successfully removed!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

removeProperty($DB_con);

?>