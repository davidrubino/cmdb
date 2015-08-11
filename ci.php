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

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/menu.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree"></div>
			<div class="col-md-8">

				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#general" data-toggle="tab">General</a>
						</li>
						<li>
							<a href="#financial" data-toggle="tab">Financial</a>
						</li>
						<li>
							<a href="#labor" data-toggle="tab">Labor</a>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="general">
							<h2 class="name"></h2>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="class-panel-general"></table>
								</div>
							</div>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title subclass-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="subclass-panel-general"></table>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="financial">
							<h2 class="name"></h2>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="class-panel-financial"></table>
								</div>
							</div>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title subclass-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="subclass-panel-financial"></table>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="labor">
							<h2 class="name"></h2>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="class-panel-labor"></table>
								</div>
							</div>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title subclass-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table" id="subclass-panel-labor"></table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="dist/jstree.min.js"></script>
		<script src="ci_tree.js"></script>
		<script src="menu.js"></script>

	</body>
</html>