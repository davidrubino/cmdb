<?php

include 'db_connect.php';

header('Content-Type: application/json');

function deleteTile($conn) {
	$id = $_POST['id'];

	try {
		$sql_data = 'select html_row, html_col
		from tile
		where id = :id';
		$stmt_data = $conn -> prepare($sql_data);
		$stmt_data -> execute(array(':id' => $id));
		$row_data = $stmt_data -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql = 'delete from tile
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row_data);
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteTile($DB_con);
?>