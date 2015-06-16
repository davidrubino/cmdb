<?php

include 'db_connect.php';

function retrieveMaps($conn) {
	$id = $_POST['id'];

	try {
		$sql = 'SELECT * FROM map_department_application WHERE application_id=?;';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute([$id]);
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);

		echo json_encode(['success' => 'yes', 'message' => "<h3>" . $row['department_id'] . "</h3>" . nl2br($row['application_id'])]);
	} catch(PDOException $e) {
		echo json_encode(['success' => 'no', 'message' => 'Could not load the map']);
	}
}

$conn = connect("localhost", "root", "america76", "test");
echo '<br>';
retrieveMaps($conn);
echo '<br>';
closeConnection($conn);
?>