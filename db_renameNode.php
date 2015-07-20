<?php

include 'db_connect.php';

function renameNode($conn) {
	//$name = "MySQL";
	//$class_id = 31;
	$name = $_POST['name'];
	$class_id = $_POST['class_id'];
	
	try {
		$sql = 'update class
		set name = :name
		where id = :class_id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':class_id' => $class_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameNode($DB_con);

?>