<?php

include 'db_connect.php';

$name = $_POST['name'];

function checkIfUnique($conn, $foo) {
	try {
		$sql_select = 'select name from data_center';
		$stmt_select = $conn -> prepare($sql_select);
		$stmt_select -> execute();
		$row_select = $stmt_select -> fetchAll(PDO::FETCH_ASSOC);
		foreach ($row_select as $i) {
			if (strcasecmp($foo, $i['name']) == 0) {
				return false;
			}
		}
		return true;
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

function createDataCenter($conn) {
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
		$stmt -> execute(array(':name' => $GLOBALS['name'], ':count_rows' => $count_rows, ':count_columns' => $count_columns, ':label_rows' => $label_rows, ':label_columns' => $label_columns, ':tile_dim' => $tile_dim));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if (checkIfUnique($DB_con, $name)) {
	createDataCenter($DB_con);
	echo "Data center created!";
} else {
	echo "The name already exists!";
}
?>