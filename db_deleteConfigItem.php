<?php

include 'db_connect.php';

function deleteConfigItem($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from property_value
		where config_id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql2 = 'delete from config_item
		where id = :id';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':id' => $id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Config item deleted!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteConfigItem($DB_con);
?>