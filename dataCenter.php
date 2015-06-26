<?php

include 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}

$user_id = $_SESSION['user_session'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Data Center</title>

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/menu.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="jumbotron">
				<h1>Data Center</h1>
			</div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="menu.js"></script>

	</body>
</html>