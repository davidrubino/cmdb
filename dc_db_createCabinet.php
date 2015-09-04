<?php

include 'db_connect.php';

function createCabinet($conn) {
	$height = $_POST['height'];
	$width = $_POST['width'];
	$tile_id = $_POST['tile_id'];

	try {
		$sql = 'insert into cabinet
		(height, width, tile_id)
		values
		(:height, :width, :tile_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':height' => $height, ':width' => $width, ':tile_id' => $tile_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Cabinet created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createCabinet($DB_con);
?>