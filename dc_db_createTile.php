<?php

include 'db_connect.php';

function createTile($conn) {
	$x = $_POST['x'];
	$y = $_POST['y'];
	$label = $_POST['label'];
	$html_row = $_POST['html_row'];
	$html_col = $_POST['html_col'];
	$data_center_id = $_POST['data_center_id'];

	try {
		$sql = 'insert into tile
		(x, y, label, grayed_out, html_row, html_col, data_center_id)
		values
		(:x, :y, :label, false, :html_row, :html_col, :data_center_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':x' => $x, ':y' => $y, ':label' => $label, ':html_row' => $html_row, ':html_col' => $html_col, ':data_center_id' => $data_center_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Tile created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createTile($DB_con);
?>