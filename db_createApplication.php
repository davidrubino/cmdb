<?php

include 'db_connect.php';

function createApplication($conn) {
	$folder_id = $_POST['folder_id'];

	try {
		$sql = 'insert into application
		(id, name, folder_id)
		select max(id) + 1, "New node", :folder_id from application';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':folder_id' => $folder_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Application created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createApplication($DB_con);
?>