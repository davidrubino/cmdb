<?php

include 'db_connect.php';

function addConfigItem($conn) {
	$value = $_POST['value'];
	$parent_id = $_POST['parent_id'];

	try {
		$sql = "
		insert into graph
		(name, type, parent_id)
		values
		(:value, 'config_item', :parent_id)
		";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':value' => $value, ':parent_id' => $parent_id));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

		echo "Configuration item created!";

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

addConfigItem($DB_con);
?>