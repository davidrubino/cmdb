<?php

include 'db_connect.php';

function retrieveValues($conn) {
	try {
		$sql = 'SELECT * FROM application ORDER BY application_id ASC;';
		$nodes = [];
		foreach ($conn->query($sql) as $row) {
			$nodes[] = ['id' => $row['application_id'], 'text' => $row['name']];
		}
		echo json_encode(['id' => -1, 'text' => 'Application', 'children' => $nodes, 'state' => ['opened' => true]]);
	} catch (PDOException $e) {
		echo json_encode(['id' => -1, 'text' => 'Application']);
	}
}

$conn = connect("localhost", "root", "america76", "test");
echo '<br>';
retrieveValues($conn);
echo '<br>';
closeConnection($conn);

?>