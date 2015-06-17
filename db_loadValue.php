<?php

include 'db_connect.php';

header('Content-Type: application/json');

function retrieveValues($conn) {
	try {
		//$root = ['id' => 0, 'parent' => '#', 'text' => 'Root', 'state' => ['opened' => true]];
		$root = array();
		$nodes = array();
		$children_nodes = array();
		$sql = 'select * from class where parent_id is null;';
		
		foreach ($conn->query($sql) as $row) {
			array_push($root, ['id' => $row['id'], 'parent' => $row['parent_id'], 'text' => $row['name'], 'state' => ['opened' => true]]);
			//$nodes[] = ['id' => $row['id'], 'parent' => $root, 'text' => $row['name'], 'state' => ['opened' => true]];
		}
		
		foreach ($root as $row) {
			$sql_children = "SELECT * from class where class.parent_id = {$row['id']}";
			foreach ($conn->query($sql_children) as $row_children) {
				array_push($nodes, ['id' => $row_children['id'], 'parent' => $row_children['parent_id'], 'text' => $row_children['name'], 'state' => ['opened' => true]]);
			}
		}
		
		foreach ($nodes as $row) {
			$sql_children = "SELECT * from class where class.parent_id = {$row['id']}";
			foreach ($conn->query($sql_children) as $row_children) {
				array_push($children_nodes, ['id' => $row_children['id'], 'parent' => $row_children['parent_id'], 'text' => $row_children['name']]);
				//$children_nodes[] = ['id' => $row_children['id'], 'parent' => $row_children['parent_id'], 'text' => $row_children['name']];
			}
		}
		$array_merged = array_merge($root, $nodes, $children_nodes);
		$origin = ['id' => -1, 'text' => 'Root', 'children' => $array_merged, 'state' => ['opened' => true]];
		echo json_encode($origin);
		//echo json_encode(['id' => -1, 'text' => 'Root', 'children' => $nodes, 'state' => ['opened' => true]]);
		//echo json_encode(['id' => -1, 'text' => 'Root', 'children' => $children_nodes, 'state' => ['opened' => true]]);
	} catch (PDOException $e) {
		echo json_encode(['id' => -1, 'text' => 'Root']);
	}
}

$conn = connect("localhost", "root", "america76", "test");
//echo '<br>';
retrieveValues($conn);
//echo '<br>';
closeConnection($conn);
?>