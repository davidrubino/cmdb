<?php

include 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}

$user_id = $_SESSION['user_session'];
$stmt = $DB_con -> prepare("SELECT * FROM user WHERE user_id=:user_id");
$stmt -> execute(array(":user_id" => $user_id));
$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);

$permission = $userRow['isAdmin'];
if ($permission == 1) {
	$user -> redirect('dc_admin.php');
}
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

			<div class="col-md-9">

				<div id="grid-controls" style="display: none">
					<div id="mygraph"></div>
					<div id="div_view">
						<input class="btn btn-large btn-primary i-graph" id="view_cabinet" type="button" value="View cabinet">
					</div>
				</div>

				<div id="server-design" style="display: none">
					<div class="col-md-2">
						<button type="button" class="btn btn-default" id="back-view" aria-label="Back" data-toggle="tooltip" data-placement="top" title="Back">
							<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
						</button>
					</div>
					<div class="col-md-10" id="racks"></div>
				</div>
			</div>

			<div class="contextMenu" id="myMenu1">
				<ul>
					<li id="show_ci">
						Show CI
					</li>
					<li id="help">
						Help
					</li>
				</ul>
			</div>

			<script src="jquery/jquery-1.11.3.js"></script>
			<script src="bootstrap/js/bootstrap.min.js"></script>
			<script src="dist/jstree.min.js"></script>
			<script src="context-menu/jquery.contextmenu.r2.js"></script>
			<script src="dc_tree.js"></script>
			<script src="menu.js"></script>
	</body>
</html>