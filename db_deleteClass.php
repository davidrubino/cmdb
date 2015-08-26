<?php

include 'db_connect.php';

function deleteClass($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from class
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Class deleted!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteClass($DB_con);
?>