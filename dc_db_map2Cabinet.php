<?php

include 'db_connect.php';

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
		
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

map2Cabinet($DB_con);
?>