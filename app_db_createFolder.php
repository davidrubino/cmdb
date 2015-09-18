<?php

include 'db_connect.php';

function createFolder($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'insert into folder
		(name, parent_id)
		values
		("New node", :id);';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Folder created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createFolder($DB_con);
?>