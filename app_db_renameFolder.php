<?php

include 'db_connect.php';

function renameFolder($conn) {
	$name = $_POST['txt-name'];
	$id = $_POST['id'];

	try {
		$sql = "
		update graph
		set name = :name
		where id = :id
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Update successful!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameFolder($DB_con);
?>