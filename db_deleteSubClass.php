<?php

include 'db_connect.php';

function deleteSubClass($conn) {
	//$id = 11;
	$id = $_POST['id'];

	try {
		$sql = 'delete from property_value
		where exists (
		    select id from config_item
		    where config_item.id = property_value.config_id
		    and config_item.class_id = :id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql2 = 'delete from config_item
		where class_id = :id';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':id' => $id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql3 = 'delete from map_class_property
		where class_id = :id';
		$stmt3 = $conn -> prepare($sql3);
		$stmt3 -> execute(array(':id' => $id));
		$row3 = $stmt3 -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql4 = 'delete from class
		where id = :id';
		$stmt4 = $conn -> prepare($sql4);
		$stmt4 -> execute(array(':id' => $id));
		$row4 = $stmt4 -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Update successful!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteSubClass($DB_con);
?>