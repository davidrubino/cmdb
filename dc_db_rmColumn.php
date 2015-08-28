<?php

include 'db_connect.php';

function removeColumn($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'update data_center 
	    set count_columns = count_columns - 1
	    where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Column removed!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

removeColumn($DB_con);
?>