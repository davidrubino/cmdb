<?php

include 'db_connect.php';

function createDataCenter($conn) {
	try {
		$sql = 'insert into data_center
		(name, count_rows, count_columns, label_rows, label_columns, tile_dim)
		values
		("New node", 10, 10, "1", "A", 2)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Data center created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createDataCenter($DB_con);
?>