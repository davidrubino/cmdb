<?php

include 'db_connect.php';

function deleteConfigItem($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from config_item
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Config item deleted!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteConfigItem($DB_con);
?>