<?php

include 'db_connect.php';

function updateDB($conn, $name, $value_type, $tab) {
	try {
		$sql = 'insert into property
		(name, value_type, tab)
		values
		(:name, :value_type, :tab);';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':name' => $name, ':value_type' => $value_type, ':tab' => $tab));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		echo "Update successful!";
	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if ($_GET) {
	if (isset($_GET['financial-class'])) {
		$name = $_GET['financial-class'];
		$value_type = $_GET['select-financial-class'];
		$tab = "financial";
		updateDB($DB_con, $name, $value_type, $tab);
	}
}
?>