<?php

include 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Show applications</title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>
		<div class="container">
			<div class="col-md-12">
				<img src="img/folder-icon.png"> Root <img src="img/folder-icon.png"> HR <img src="img/folder-icon.png"> PayRoll <img src="img/file-icon.png"><a href="app_admin.php">RollPayer</a>
			</div>
		</div>
	</body>
</html>