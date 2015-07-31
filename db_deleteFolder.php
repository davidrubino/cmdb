<?php

include 'db_connect.php';

function deleteFolder($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from folder
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Folder deleted!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteFolder($DB_con);
?>