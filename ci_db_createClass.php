<?php

include 'db_connect.php';

function createClass($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'insert into class
		(name, parent_id)
		values
		("New node", :id);';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Class created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

createClass($DB_con);
?>