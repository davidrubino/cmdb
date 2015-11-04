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

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
		
		<link href="css/menu.css" rel="stylesheet">
		<link href="css/grid.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="row">
				<div class="col-md-3" id="tree"></div>
				<div class="col-md-6">
					<div id="grid-controls" style="display: none">
						<div id="mygraph"></div>
						<div class="div_controls">
							<input class="btn btn-large btn-primary i-graph" id="view_cabinet" type="button" value="View cabinet">
						</div>
					</div>

					<div id="server-design" style="display: none">
						<div class="row">
							<div class="col-md-2">
								<button type="button" class="btn btn-default" id="back-view" aria-label="Back" data-toggle="tooltip" data-placement="top" title="Back">
									<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
								</button>
							</div>

							<div class="col-md-10">
								<div class="row">
									<div class="col-md-12">
										<img src="img/cabinet2.png">
									</div>
								</div>
								<div class="row">
									<div class="col-md-10" id="racks-container">
										<div id="racks"></div>
									</div>
									<div class="col-md-2" id="img-container">
										<img src="img/cabinet1.png">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="contextMenu" id="myMenu1">
				<ul>
					<li id="show_app">
						Show applications
					</li>
					<li id="show_ci">
						Show CI
					</li>
					<li id="help">
						Help
					</li>
				</ul>
			</div>

			<div id="dialog" title="Applications"></div>

			<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
			<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
			<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
			<script src="http://www.trendskitchens.co.nz/jquery/contextmenu/jquery.contextmenu.r2.packed.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
			
			<script src="dist/jstree.min.js"></script>
			<script src="dc_tree.js"></script>
			<script src="menu.js"></script>
	</body>
</html>