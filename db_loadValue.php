<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveValues($conn) {
	try {
		$nodes = array();
		$sql = 'select * from class where parent_id is null;';
		$sql_ci = 'select config_item.id, config_item.class_id from config_item, class where config_item.class_id = class.id';
		
		foreach ($conn->query($sql) as $row) {
			$children_nodes = array();
			$sql_children = "SELECT * from class where class.parent_id = {$row['id']}";
			foreach ($conn->query($sql_children) as $row_children) {
				array_push($children_nodes, ['id' => $row_children['id'], 'text' => $row_children['name'], 'children' => array(), 'state' => ['opened' => false]]);
			}
			array_push($nodes, ['id' => $row['id'], 'text' => $row['name'], 'children' => $children_nodes, 'state' => ['opened' => true]]);
		}
		
		$root = ['id' => -1, 'text' => 'Root', 'children' => $nodes, 'state' => ['opened' => true]];
		echo json_encode($root);
		
	} catch (PDOException $e) {
		echo json_encode(['id' => -1, 'text' => 'Root']);
	}
}

$conn = connect("localhost", "root", "america76", "test");
retrieveValues($conn);
closeConnection($conn);
?>