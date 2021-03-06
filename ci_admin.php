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

if ($permission == 0) {
	$user -> redirect('ci.php');
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
		
		<link rel="stylesheet" href="css/menu.css">
		<link rel="stylesheet" href="css/ci.css">
		<link rel="stylesheet" href="dist/themes/default/style.min.css">
		
	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree-ci"></div>
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
					<div id="fileData_general">
						<div class="alert alert-success" role="alert" style="display: none"></div>
						<form class="value-form" role="form" method="post"></form>
					</div>

					<div id="folderData_general">
						<form class="property-form" role="form" method="post">
							<div class="panel panel-primary class-panel">
								<div class="panel-heading">
									<h3 class="panel-title property-class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table selectable property-table"></table>
								</div>
								<div class="controls">
									<a href="#" class="add-toggler"><img src="img/add-icon.png"></a>
									<a href="#" class="rm-toggler"><img src="img/remove-icon.png"></a>
								</div>
							</div>

							<div class="btn-group" style="display: none">
								<button type="submit" class="btn btn-large btn-primary">
									Save
								</button>
								<input type="button" value="Cancel" class="btn btn-large btn-default btn-cancel">
							</div>
						</form>
					</div>
				</div>

				<div id="financial">
					<div id="fileData_financial">
						<div class="alert alert-success" role="alert" style="display: none"></div>
						<form class="value-form" role="form" method="post"></form>
					</div>

					<div id="folderData_financial">
						<form class="property-form" role="form" method="post">
							<div class="panel panel-primary class-panel">
								<div class="panel-heading">
									<h3 class="panel-title property-class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table selectable property-table"></table>
								</div>
								<div class="controls">
									<a href="#" class="add-toggler"><img src="img/add-icon.png"></a>
									<a href="#" class="rm-toggler"><img src="img/remove-icon.png"></a>
								</div>
							</div>

							<div class="col-sm-12 controls btn-group" style="display: none">
								<button type="submit" class="btn btn-large btn-primary">
									Save
								</button>
								<input type="button" value="Cancel" class="btn btn-large btn-default btn-cancel">
							</div>
						</form>
					</div>
				</div>

				<div id="labor">
					<div id="fileData_labor">
						<div class="alert alert-success" role="alert" style="display: none"></div>
						<form class="value-form" role="form" method="post"></form>
					</div>

					<div id="folderData_labor">
						<form class="property-form" role="form" method="post">
							<div class="panel panel-primary class-panel">
								<div class="panel-heading">
									<h3 class="panel-title property-class-title"></h3>
								</div>
								<div class="table-responsive">
									<table class="table selectable property-table"></table>
								</div>
								<div class="controls">
									<a href="#" class="add-toggler"><img src="img/add-icon.png"></a>
									<a href="#" class="rm-toggler"><img src="img/remove-icon.png"></a>
								</div>
							</div>

							<div class="col-sm-12 controls btn-group" style="display: none">
								<button type="submit" class="btn btn-large btn-primary">
									Save
								</button>
								<input type="button" value="Cancel" class="btn btn-large btn-default btn-cancel">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
		
		<script src="dist/jstree.min.js"></script>
		<script src="ci_admin_tree.js"></script>
		<script src="menu.js"></script>

	</body>
</html>