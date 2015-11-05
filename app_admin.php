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
	$user -> redirect('app.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Applications</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.9.0/vis.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

		<link href="css/menu.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">
		<link href="css/graph.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree"></div>
			<div class="col-md-6" id="mynetwork" style="display:none"></div>

			<div class="col-md-2" id="control-panel" style="display:none">
				<input class="btn btn-large btn-primary i-graph" type="button" id="addFolder" value="Add folder">

				<input class="btn btn-large btn-primary i-graph" type="button" id="loadConfigItems" value="Add configuration item">

				<div class="form-group" style="display:none">
					<select class="form-control" id="select-ci" size="5" name="selectionField" form="form1"></select>
					<form id="form1" role="form" method="post">
						<button class="btn btn-large btn-primary i-graph" type="submit">
							OK
						</button>
						<input class="btn btn-large btn-default i-graph" type="button" value="Cancel" id="cancel-select-ci">
					</form>
				</div>

				<input class="btn btn-large btn-primary i-graph" type="button" id="renameFolder" value="Rename folder">
				<span class="cat1" style="display:none">
					<form class="form-horizontal" role="form" method="post">
						<input class="form-control i-graph" name="txt-name">
						<button class="btn btn-sm btn-info i-graph" type="submit">
							Save
						</button>
						<input class="btn btn-sm btn-cancel i-graph" type="button" value="Cancel">
					</form> </span>

				<input class="btn btn-large btn-primary i-graph" type="button" id="removeItem" value="Remove item">
			</div>

		</div>

		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.9.0/vis.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		<script src="dist/jstree.min.js"></script>
		<script src="app_admin_tree.js"></script>
		<script src="menu.js"></script>

	</body>
</html>