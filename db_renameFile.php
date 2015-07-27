<?php

include 'db_connect.php';

function renameFile($conn) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	try {
		$sql = 'update config_item
		set name = :name
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo "Update successful!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameFile($DB_con);
?>