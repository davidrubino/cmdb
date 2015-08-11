<?php

include 'db_connect.php';

function createApplication($conn) {
	$folder_id = $_POST['folder_id'];

	try {
		$sql = 'insert into application
		(id, name, folder_id)
		select max(id) + 1, "New node", :folder_id from application';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':folder_id' => $folder_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Application created!";
		echo "<br>";
		
		$sql_graph = 'insert into graph
		(name, type, parent_id, application_id)
		values
		("New node", "app", NULL, (select id from application
			order by id desc 
			limit 1))';
		$stmt_graph = $conn -> prepare($sql_graph);
		$stmt_graph -> execute();
		$row_graph = $stmt_graph -> fetchAll(PDO::FETCH_ASSOC);

		echo "Graph created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createApplication($DB_con);
?>