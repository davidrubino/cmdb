<?php

include 'db_connect.php';

function deleteTile($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from tile
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Tile deleted!";
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteTile($DB_con);
?>