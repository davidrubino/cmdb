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
	$user -> redirect('configItem.php');
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
							<a class="active" href="#general" data-toggle="tab">General</a>
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

							<div id="fileData_general">
								<form class="form-horizontal" id="form-general" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-general"></table>
										</div>
									</div>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-general"></table>
										</div>
									</div>

									<div class="btn-group-file">
										<button type="submit" name="general-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
										</input>
									</div>
								</form>
							</div>

							<div id="subfolderData_general">
								<form class="form-horizontal" id="form-general-subclass" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-general-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-general-subclass-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-general-subclass-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-subfolder-general" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
							</div>

							<div id="folderData_general">
								<form class="form-horizontal" id="form-general-class" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-general-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-general-class-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-general-class-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-folder-general" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
							</div>
						</div>

						<div class="tab-pane" id="financial">

							<div id="fileData_financial">
								<form class="form-horizontal" id="form-financial" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-financial"></table>
										</div>
									</div>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-financial"></table>
										</div>
									</div>

									<div class="btn-group-file">
										<button type="submit" name="financial-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
										</input>
									</div>

								</form>
							</div>

							<div id="subfolderData_financial">
								<form class="form-horizontal" id="form-financial-subclass" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-financial-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-financial-subclass-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-financial-subclass-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-subfolder-financial" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
							</div>

							<div id="folderData_financial">
								<form class="form-horizontal" id="form-financial-class" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-financial-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-financial-class-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-financial-class-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-folder-financial" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
							</div>
						</div>

						<div class="tab-pane" id="labor">
							<div id="fileData_labor">
								<form class="form-horizontal" id="form-labor" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-labor"></table>
										</div>
									</div>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-labor"></table>
										</div>
									</div>

									<div class="btn-group-file">
										<button type="submit" name="labor-btn-save" class="btn btn-large btn-primary">
											Save settings
										</button>
										<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
										</input>
									</div>

								</form>
							</div>
							
							<div id="subfolderData_labor">
								<form class="form-horizontal" id="form-labor-subclass" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary subclass-panel">
										<div class="panel-heading">
											<h3 class="panel-title subclass-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="subclass-panel-labor-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-labor-subclass-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-labor-subclass-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-subfolder-labor" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
							</div>
							
							<div id="folderData_labor">
								<form class="form-horizontal" id="form-labor-class" role="form" method="post">
									<h2 class="name"></h2>

									<div class="panel panel-primary class-panel">
										<div class="panel-heading">
											<h3 class="panel-title class-title"></h3>
										</div>
										<div class="table-responsive">
											<table class="table" id="class-panel-labor-data"></table>
										</div>
										<div class="controls">
											<a href="#" id="add-labor-class-toggler"><img src="img/add-icon.png"></a>
											<a href="#" id="rm-labor-class-toggler"><img src="img/remove-icon.png"></a>
										</div>
									</div>

									<div class="btn-group-folder-labor" style="display: none">
										<div class="col-sm-12 controls">
											<button type="submit" class="btn btn-large btn-primary">
												Save settings
											</button>
											<input type="button" value="Cancel" class="btn btn-large btn-default" onclick="document.location.href='configItem_admin.php';">
											</input>
										</div>
									</div>
								</form>
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
		<script src="tree_admin.js"></script>
		<script src="menu.js"></script>

	</body>
</html>