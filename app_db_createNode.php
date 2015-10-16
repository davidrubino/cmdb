<?php

include 'db_connect.php';

function createFolder($conn) {
	$parent_id = $_POST['parent_id'];
	$application_id = $_POST['application_id'];

	try {
		$sql = "
		insert into graph
		(name, type, parent_id, application_id, config_item_id)
		values
		('New Folder', 'folder', :parent_id, :application_id, NULL)
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':parent_id' => $parent_id, 'application_id' => $application_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Folder created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createFolder($DB_con);
?>