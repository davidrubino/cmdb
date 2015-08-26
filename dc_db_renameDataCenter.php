<?php

include 'db_connect.php';

function renameDataCenter($conn) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	try {
		$sql = "update data_center
		set name = :name
		where id = :id";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Data_center updated!";
		echo "<br>";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameDataCenter($DB_con);
?>