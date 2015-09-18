<?php

include 'db_connect.php';

function renameFolder($conn) {
	$name = $_POST['name'];
	$parent_id = $_POST['parent_id'];
	
	try {
		$sql = 'update folder
		set name = :name
		where id = :parent_id';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':parent_id' => $parent_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

renameFolder($DB_con);

?>