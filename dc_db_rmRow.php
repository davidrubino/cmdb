<?php

include 'db_connect.php';

function removeRow($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'update data_center 
	    set count_rows = count_rows - 1
	    where id = :id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Row removed!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

removeRow($DB_con);
?>