<?php

include 'db_connect.php';

function deleteApplication($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from application
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Application deleted!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteApplication($DB_con);
?>