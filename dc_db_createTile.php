<?php

include 'db_connect.php';

function createTile($conn) {
	$id = $_POST['id'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$label = $_POST['label'];
	$grayed_out = $_POST['grayed_out'];
	$html_row = $_POST['html_row'];
	$html_col = $_POST['html_col'];
	$data_center_id = $_POST['data_center_id'];

	try {
		$sql = 'insert into tile
		(id, x, y, label, grayed_out, html_row, html_col, data_center_id)
		values
		(:id, :x, :y, :label, :grayed_out, :html_row, :html_col, :data_center_id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id, ':x' => $x, ':y' => $y, ':label' => $label, ':grayed_out' => $grayed_out, ':html_row' => $html_row, ':html_col' => $html_col, ':data_center_id' => $data_center_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Tile created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createTile($DB_con);
?>