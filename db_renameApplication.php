<?php

include 'db_connect.php';

function renameApplication($conn) {
	$name = $_POST['name'];
	$id = $_POST['id'];

	try {
		$sql = 'update application
		set name = :name
		where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Application updated!";
		echo "<br>";
		
		$sql_graph = 'update graph
		set name = :name
		where application_id = :id
		and type = "app"';
		$stmt_graph = $conn -> prepare($sql_graph);
		$stmt_graph -> execute(array(':name' => $name, ':id' => $id));
		$row_graph = $stmt_graph -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Graph updated!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameApplication($DB_con);
?>