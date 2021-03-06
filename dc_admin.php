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
if ($permission == 0) {
	$user -> redirect('dc.php');
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
						<div class="div_controls controls">
							<input class="btn btn-large btn-primary i-graph" id="activate" type="button" value="Activate cell">
							<input class="btn btn-large btn-primary i-graph" id="gray-out" type="button" value="Gray out">
							<input class="btn btn-large btn-primary i-graph" id="addCabinet" type="button" value="Add cabinet">
							<input class="btn btn-large btn-primary i-graph" id="rmCabinet" type="button" value="Remove cabinet">
						</div>
						<div class="div_controls">
							<input class="btn btn-large btn-primary i-graph" id="view_cabinet" type="button" value="View cabinet">
						</div>
						<div class="div_controls controls">
							<input class="btn btn-large btn-primary i-graph" id="addRow" type="button" value="Add row">
							<input class="btn btn-large btn-primary i-graph" id="addCol" type="button" value="Add column">
							<input class="btn btn-large btn-primary i-graph" id="rmRow" type="button" value="Remove row">
							<input class="btn btn-large btn-primary i-graph" id="rmCol" type="button" value="Remove column">
						</div>
					</div>

					<div id="grid-form" style="display: none">
						<div class="alert alert-danger" id="alert1" role="alert" style="display: none">
							There are errors on this page!
						</div>
						<form id="form1" role="form" method="post">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Name</td>
										<td>
										<input type="text" id="name" name="name" value="New node">
										</td>
										<td><span id="error-name" class="error">Please enter a valid name</span></td>
									</tr>
									<tr>
										<td>Number of rows</td>
										<td>
										<input type="number" id="count_rows" name="count_rows" value="10">
										</td>
										<td><span id="error-count_rows" class="error">Please enter a valid number</span></td>
									</tr>
									<tr>
										<td>Number of columns</td>
										<td>
										<input type="number" id="count_columns" name="count_columns" value="10">
										</td>
										<td><span id="error-count_columns" class="error">Please enter a valid number</span></td>
									</tr>
									<tr>
										<td>Rows label</td>
										<td>
										<input type="text" id="label_rows" name="label_rows" value="1">
										</td>
										<td><span id="error-label_rows" class="error">Please enter a number or a letter</span></td>
									</tr>
									<tr>
										<td>Columns label</td>
										<td>
										<input type="text" id="label_columns" name="label_columns" value="A">
										</td>
										<td><span id="error-label_columns" class="error">Please enter a number or a letter</span></td>
									</tr>
									<tr>
										<td>Tile dimension</td>
										<td>
										<input type="number" id="tile_dim" name="tile_dim" value="2">
										</td>
										<td><span id="error-tile_dim" class="error">Please enter a valid number</span></td>
									</tr>
								</table>
							</div>
							<div class="col-sm-12 controls btn-group">
								<button type="submit" class="btn btn-large btn-primary">
									Save
								</button>
								<input type="button" value="Cancel" id="create-dc-cancel" class="btn btn-large btn-default">
							</div>
						</form>
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

				<div class="col-md-3 container-fluid">
					<div id="cabinet-form" style="display: none">
						<form id="form2" role="form" method="post">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Height</td>
										<td>
										<input type="number" class="number-cells" id="height" name="height" value="7" min="1" max="100">
										</td>
										<td><span id="error-height" class="error">Please enter a valid height</span></td>
									</tr>
									<tr>
										<td>Width</td>
										<td>
										<input type="number" class="number-cells" id="width" name="width" value="3" min="1" max="100">
										</td>
										<td><span id="error-width" class="error">Please enter a valid width</span></td>
									</tr>
									<tr>
										<td>Color</td>
										<td>
										<input type="color" class="number-cells" id="color "name="color">
										</td>
									</tr>
								</table>
							</div>
							<div class="col-sm-12 controls btn-group">
								<button type="submit" class="btn btn-large btn-primary">
									Save
								</button>
								<input type="button" value="Cancel" id="create-cabinet-cancel" class="btn btn-large btn-default">
							</div>
						</form>
					</div>

					<div class="form-group" style="display: none">
						<label for="select-ci">Select the server to add:</label>
						<select class="form-control" id="select-ci" size="5" name="selectionField" form="form3"></select>
						<form id="form3" role="form" method="post">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td>Height</td>
										<td>
										<input type="number" class="number-cells" id="item-height" name="item-height" value="1" min="1" max="100">
										</td>
										<td><span id="error-item-height" class="error">Please enter a valid height</span></td>
									</tr>
								</table>
							</div>
							<button type="submit" class="btn btn-large btn-primary">
								OK
							</button>
							<input type="button" value="Cancel" id="cancel-select-ci" class="btn btn-large btn-default">
						</form>
					</div>
				</div>
			</div>

			<div class="contextMenu" id="myMenu1">
				<ul>
					<li id="add_ci">
						Add CI
					</li>
					<li id="show_app">
						Show applications
					</li>
					<li id="show_ci">
						Show CI
					</li>
					<li id="rm_ci">
						Remove CI
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
			<script src="dc_admin_tree.js"></script>
			<script src="menu.js"></script>
	</body>
</html>