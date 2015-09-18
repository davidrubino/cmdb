<?php

include 'db_connect.php';

header('Content-Type: application/json');

function createCabinet($conn) {
	$height = $_POST['height'];
	$width = $_POST['width'];
	$color = $_POST['color'];
	$tile_id = $_POST['tile_id'];

	try {
		$sql = 'insert into cabinet
		(id, height, width, color, tile_id)
		values
		(:id, :height, :width, :color, :tile_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $tile_id, ':height' => $height, ':width' => $width, ':color' => $color, ':tile_id' => $tile_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql_select = 'select * from cabinet
		order by id desc 
		limit 1;';
		$stmt_select = $conn -> prepare($sql_select);
		$stmt_select -> execute();
		$row_select = $stmt_select -> fetchAll(PDO::FETCH_ASSOC);
		
		echo json_encode($row_select);

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createCabinet($DB_con);
?>