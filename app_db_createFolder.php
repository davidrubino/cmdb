<?php

include 'db_connect.php';

function createFolder($conn) {
	$parent_id = $_POST['parent_id'];

	try {
		$sql = "
		insert into graph
		(name, type, parent_id)
		values
		('New Folder', 'folder', :parent_id)
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':parent_id' => $parent_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Folder created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createFolder($DB_con);
?>