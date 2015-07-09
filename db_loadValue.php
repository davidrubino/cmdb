<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveValues($conn) {
	try {
		$nodes = array();
		$sql = 'select * from class where parent_id is null;';
		//select the main classes (database, network, server, storage)
		foreach ($conn->query($sql) as $row) {
			$children_nodes = array();
			$sql_children = "SELECT * from class where class.parent_id = {$row['id']}";

			//select the subclasses of each class (mysql, oracle, sqlserver...)
			foreach ($conn->query($sql_children) as $row_children) {
				$config_items = array();
				$sql_ci = "select config_item.id, config_item.class_id from config_item where config_item.class_id = {$row_children['id']}";

				//select the config items of each subclass
				foreach ($conn->query($sql_ci) as $row_ci) {
					$sql_ci_name = "select property_value.id, property_value.str_value from property_value, property
					where property_value.config_id = {$row_ci['id']}
					and property_value.property_id = property.id
					and property.name = 'hostname'
					";
					$result = "";
					
					//select the hostname of each config item
					foreach ($conn->query($sql_ci_name) as $ci_name) {
						$result = $ci_name['str_value'];
					}
					array_push($config_items, ['id' => $row_ci['id'], 'text' => $result, 'type' => 'file']);
				}
				array_push($children_nodes, ['id' => $row_children['id'], 'text' => $row_children['name'], 'type' => 'subfolder', 'children' => $config_items, 'state' => ['opened' => true]]);
			}
			array_push($nodes, ['id' => $row['id'], 'text' => $row['name'], 'type' => 'folder', 'children' => $children_nodes, 'state' => ['opened' => true]]);
		}

		$root = ['id' => -1, 'text' => 'Root', 'children' => $nodes, 'state' => ['opened' => true]];
		echo json_encode($root);

	} catch (PDOException $e) {
		echo json_encode(['id' => -1, 'text' => 'Root']);
	}
}

retrieveValues($DB_con);
?>