<?php

include 'db_connect.php';

function createCabinet($conn) {
	$height = $_POST['height'];
	$width = $_POST['width'];
	$color = $_POST['color'];
	$tile_id = $_POST['tile_id'];

	try {
		$sql = 'insert into cabinet
		(height, width, color, tile_id)
		values
		(:height, :width, :color, :tile_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':height' => $height, ':width' => $width, ':color' => $color, ':tile_id' => $tile_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Cabinet created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createCabinet($DB_con);
?>