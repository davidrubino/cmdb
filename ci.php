<?php

include_once 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}

$user_id = $_SESSION['user_session'];
$stmt = $DB_con -> prepare("SELECT * FROM user WHERE user_id=:user_id");
$stmt -> execute(array(":user_id" => $user_id));
$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);

$permission = $userRow['isAdmin'];

if ($permission == 1) {
	$user -> redirect('ci_admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Configuration Items</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css">
		
		<link href="css/menu.css" rel="stylesheet">
		<link href="css/ci.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree"></div>
			<div class="col-md-8" id="tabs" style="display: none">
				<h2 class="name"></h2>
				<ul>
					<li class="active">
						<a href="#general">General</a>
					</li>
					<li>
						<a href="#financial">Financial</a>
					</li>
					<li>
						<a href="#labor">Labor</a>
					</li>
				</ul>

				<div id="general">
					<div class="values" id="fileData_general"></div>

					<div class="class-panel" id="folderData_general">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title property-class-title"></h3>
							</div>
							<div class="table-responsive">
								<table class="table selectable property-table"></table>
							</div>
						</div>
					</div>
				</div>

				<div id="financial">
					<div class="values" id="fileData_financial"></div>

					<div class="class-panel" id="folderData_financial">
						<div class="panel panel-primary class-panel">
							<div class="panel-heading">
								<h3 class="panel-title property-class-title"></h3>
							</div>
							<div class="table-responsive">
								<table class="table selectable property-table"></table>
							</div>
						</div>
					</div>
				</div>

				<div id="labor">
					<div class="values" id="fileData_labor"></div>

					<div class="class-panel" id="folderData_labor">
						<div class="panel panel-primary class-panel">
							<div class="panel-heading">
								<h3 class="panel-title property-class-title"></h3>
							</div>
							<div class="table-responsive">
								<table class="table selectable property-table"></table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		<script src="dist/jstree.min.js"></script>
		<script src="ci_tree.js"></script>
		<script src="menu.js"></script>

	</body>
</html>