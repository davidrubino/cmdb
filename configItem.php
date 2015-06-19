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
				<h2 id="name"></h2>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" id="class-panel"></h3>
					</div>
					<table class="table">
						<tr>
							<td> hostname </td>
							<td> bashful </td>
						</tr>
						<tr>
							<td> fully qualified name </td>
							<td> bashful.kohls.com </td>
						</tr>
					</table>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">server: Linux</h3>
					</div>
					<table class="table">
						<tr>
							<td> RedHat Version </td>
							<td> 5.3 </td>
						</tr>
						<tr>
							<td> satellite host </td>
							<td> doc </td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="dist/jstree.min.js"></script>
		<script src="tree.js"></script>
		<script src="menu.js"></script>

	</body>
	</body>
</html>