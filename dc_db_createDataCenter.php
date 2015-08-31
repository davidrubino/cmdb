<?php

include 'db_connect.php';

function createDataCenter($conn) {
	$name = $_POST['name'];
	$count_rows = $_POST['count_rows'];
	$count_columns = $_POST['count_columns'];
	$label_rows = $_POST['label_rows'];
	$label_columns = $_POST['label_columns'];
	$tile_dim = $_POST['tile_dim'];

	try {
		$sql = 'insert into data_center
		(name, count_rows, count_columns, label_rows, label_columns, tile_dim)
		values
		(:name, :count_rows, :count_columns, :label_rows, :label_columns, :tile_dim)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':count_rows' => $count_rows, ':count_columns' => $count_columns, ':label_rows' => $label_rows, ':label_columns' => $label_columns, ':tile_dim' => $tile_dim));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Data center created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createDataCenter($DB_con);
?>