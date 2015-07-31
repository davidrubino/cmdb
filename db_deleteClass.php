<?php

include 'db_connect.php';

function deleteClass($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'delete from property
		where exists (
			select map_class_property.id from map_class_property
			where property.id = map_class_property.prop_id
			and map_class_property.class_id = :id)';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':id' => $id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		$sql1 = 'delete from map_class_property
		where class_id = :id';
		$stmt1 = $conn -> prepare($sql1);
		$stmt1 -> execute(array(':id' => $id));
		$row1 = $stmt1 -> fetchAll(PDO::FETCH_ASSOC);

		$sql2 = 'delete from class
		where id = :id';
		$stmt2 = $conn -> prepare($sql2);
		$stmt2 -> execute(array(':id' => $id));
		$row2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
		
		echo "Class deleted!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

deleteClass($DB_con);
?>