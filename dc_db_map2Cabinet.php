<?php

include 'db_connect.php';

header('Content-Type: application/json');

function map2Cabinet($conn) {
	$position = $_POST['position'];
	$ci_id = $_POST['selectionField'];
	$cabinet_id = $_POST['cabinet_id'];

	try {
		$sql = 'insert into map_ci_cabinet
		(position, ci_id, cabinet_id)
		values
		(:position, :ci_id, :cabinet_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':position' => $position, ':ci_id' => $ci_id, ':cabinet_id' => $cabinet_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		$sql_return = 'select name from config_item
		where id = :id';
		$stmt_return = $conn -> prepare($sql_return);
		$stmt_return -> execute(array(':id' => $ci_id));
		$row_return = $stmt_return -> fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($row_return);

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

map2Cabinet($DB_con);
?>