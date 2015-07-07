<?php

include_once 'db_connect.php';

function updateDB($conn, $value, $name) {

	try {
		$sql = 'update property_value, property
		set	property_value.str_value = if(property_value.str_value is null, null, :value1),
			property_value.date_value = if(property_value.date_value is null, null, :value2),
			property_value.float_value = if(property_value.float_value is null, null, :value3)
		where property_value.property_id = property.id
		and property.name = :name';
		$stmt = $conn -> prepare($sql);
		$stmt -> execute(array(':value1' => $value, ':value2' => $value, ':value3' => $value, ':name' => $name));
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

	} catch(PDOException $e) {
		echo $e -> getMessage();
	}
}

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}

$user_id = $_SESSION['user_session'];
$stmt = $DB_con -> prepare("SELECT * FROM user WHERE user_id=:user_id");
$stmt -> execute(array(":user_id" => $user_id));
$userRow = $stmt -> fetch(PDO::FETCH_ASSOC);
$permission = $userRow['isAdmin'];

if ($permission == 0) {
	$user -> redirect('configItem.php');
}

if (isset($_POST['general-btn-save'])) {
	$value = "bashful.walmart.com";
	$name = "fully qualified name";
	updateDB($DB_con, $value, $name);
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
							<form class="form-horizontal" role="form" method="post">
								<h2 class="name"></h2>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title class-title"></h3>
									</div>
									<table class="table" id="class-panel-general"></table>
								</div>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title subclass-title"></h3>
									</div>
									<table class="table" id="subclass-panel-general"></table>
								</div>

								<div class="btn-group">
									<div class="col-sm-12 controls">
										<button type="submit" name="general-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<button type="submit" name="general-btn-cancel" class="btn btn-large btn-default">
											Cancel
										</button>
									</div>
								</div>
							</form>
						</div>

						<div class="tab-pane" id="financial">
							<form class="form-horizontal" role="form" method="post">
								<h2 class="name"></h2>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title class-title"></h3>
									</div>
									<table class="table" id="class-panel-financial"></table>
								</div>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title subclass-title"></h3>
									</div>
									<table class="table" id="subclass-panel-financial"></table>
								</div>

								<div class="btn-group">
									<div class="col-sm-12 controls">
										<button type="submit" name="financial-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<button type="submit" name="financial-btn-cancel" class="btn btn-large btn-default">
											Cancel
										</button>
									</div>
								</div>
							</form>
						</div>

						<div class="tab-pane" id="labor">
							<form class="form-horizontal" role="form" method="post">
								<h2 class="name"></h2>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title class-title"></h3>
									</div>
									<table class="table" id="class-panel-labor"></table>
								</div>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title subclass-title"></h3>
									</div>
									<table class="table" id="subclass-panel-labor"></table>
								</div>

								<div class="btn-group">
									<div class="col-sm-12 controls">
										<button type="submit" name="labor-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<button type="submit" name="labor-btn-cancel" class="btn btn-large btn-default">
											Cancel
										</button>
									</div>
								</div>
							</form>
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
		<script src="tree_admin.js"></script>
		<script src="menu.js"></script>

	</body>
</html>