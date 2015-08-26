<?php

include 'db_connect.php';

function deleteDataCenter($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from data_center
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Data center deleted!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteDataCenter($DB_con);
?>