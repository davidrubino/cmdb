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
		<link href="css/grid.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-3" id="tree"></div>
			<div class="col-md-9" id="mygraph"></div>
			<div>
				<input class="btn btn-large btn-primary i-graph" id="activate" type="button" value="Activate cell">
				<input class="btn btn-large btn-primary i-graph" id="gray-out" type="button" value="Gray out">
				<input class="btn btn-large btn-primary i-graph" id="addDC" type="button" value="Add data center">
				<input class="btn btn-large btn-primary i-graph" id="rmDC" type="button" value="Remove data center">
				<input class="btn btn-large btn-primary i-graph" id="addRow" type="button" value="Add row">
				<input class="btn btn-large btn-primary i-graph" id="addCol" type="button" value="Add column">
			</div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="dist/jstree.min.js"></script>
		<script src="dc_tree.js"></script>
		<script src="menu.js"></script>
	</body>
</html>