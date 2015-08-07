<?php

include 'db_connect.php';

function removeItem($conn) {
	$id = $_POST['id'];

	try {
		$sql = "
		delete from graph
		where id = :id;
		";
		
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Item removed!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

removeItem($DB_con);
?>