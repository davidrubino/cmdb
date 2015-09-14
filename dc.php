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
			<div class="col-md-6">
				<div id="grid-controls" style="display: none">
					<div id="mygraph"></div>
					<div class="controls">
						<input class="btn btn-large btn-primary i-graph" id="activate" type="button" value="Activate cell">
						<input class="btn btn-large btn-primary i-graph" id="gray-out" type="button" value="Gray out">
						<input class="btn btn-large btn-primary i-graph" id="addCabinet" type="button" value="Add cabinet">
						<input class="btn btn-large btn-primary i-graph" id="rmCabinet" type="button" value="Remove cabinet">
						<input class="btn btn-large btn-primary i-graph" id="3d" type="button" value="3D">
					</div>
					<div class="controls">
						<input class="btn btn-large btn-primary i-graph" id="addRow" type="button" value="Add row">
						<input class="btn btn-large btn-primary i-graph" id="addCol" type="button" value="Add column">
						<input class="btn btn-large btn-primary i-graph" id="rmRow" type="button" value="Remove row">
						<input class="btn btn-large btn-primary i-graph" id="rmCol" type="button" value="Remove column">
					</div>
				</div>

				<div id="grid-form" style="display: none">
					<div class="alert alert-info" id="alert1" role="alert" style="display: none"></div>
					<div class="alert alert-danger" id="alert2" role="alert" style="display: none">
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
			</div>
			<div class="col-md-3">
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