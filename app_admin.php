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

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/menu.css" rel="stylesheet">
		<link href="dist/themes/default/style.min.css" rel="stylesheet">
		<link href="dist-vis/vis.css" rel="stylesheet">
		<link href="css/graph.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" >

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree"></div>
			<div class="col-md-6" id="mynetwork" style="display:none"></div>
			<div class="col-md-2" id="control-panel" style="display:none">
				<input class="btn btn-large btn-primary i-graph" type="button" onclick="addFolder()" value="Add folder">
				<input class="btn btn-large btn-primary i-graph" type="button" onclick="loadConfigItem()" value="Add configuration item">
				<span class="span-cfg"></span>
				<input class="btn btn-large btn-primary i-graph" type="button" onclick="renameFolder()" value="Rename folder">

				<span class="cat1" style="display:none">
					<form class="form-horizontal" role="form" method="post">
						<input class="form-control i-graph" name="txt-name">
						<button class="btn btn-sm btn-info i-graph" type="submit">
							Save
						</button>
						<input class="btn btn-sm btn-info i-graph" type="button" onclick="document.location.href='app_admin.php';" value="Cancel">
					</form> </span>

				<input class="btn btn-large btn-primary i-graph" type="button" onclick="removeItem()" value="Remove item">
			</div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="dist/jstree.min.js"></script>
		<script src="app_admin_tree.js"></script>
		<script src="menu.js"></script>
		<script src="dist-vis/vis.js"></script>

	</body>
</html>