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
		<link href="dist/themes/default/style.min.css" rel="stylesheet">

	</head>

	<body onload="drawVisualization()">

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div class="col-md-4" id="tree"></div>
			<div class="col-md-8" id="mygraph"></div>
		</div>

		<?php
		include 'footer.php';
		?>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="dist/jstree.min.js"></script>
		<script src="dc_tree.js"></script>
		<script src="menu.js"></script>
		<script src="dist-vis/vis.js"></script>
		<script type="text/javascript">
			var data = null;
			var graph = null;

			function custom(x, y) {
				return (-Math.sin(x / Math.PI) * Math.cos(y / Math.PI) * 10 + 10);
			}

			// Called when the Visualization API is loaded.
			function drawVisualization() {
				var style = "bar-size";
				var withValue = ['bar-color', 'bar-size', 'dot-size', 'dot-color'].indexOf(style) != -1;

				// Create and populate a data table.
				data = new vis.DataSet();

				// create some nice looking data with sin/cos
				var steps = 5;
				// number of datapoints will be steps*steps
				var axisMax = 10;
				var axisStep = axisMax / steps;
				for (var x = 0; x <= axisMax; x += axisStep) {
					for (var y = 0; y <= axisMax; y += axisStep) {
						var z = custom(x, y);
						if (withValue) {
							var value = (y - x);
							data.add({
								x : x,
								y : y,
								z : z,
								style : value
							});
						} else {
							data.add({
								x : x,
								y : y,
								z : z
							});
						}
					}
				}

				// specify options
				var options = {
					width : '600px',
					height : '450px',
					style : style,
					showPerspective : true,
					showGrid : true,
					showShadow : false,

					// Option tooltip can be true, false, or a function returning a string with HTML contents
					//tooltip: true,
					tooltip : function(point) {
						// parameter point contains properties x, y, z
						return 'value: <b>' + point.z + '</b>';
					},

					keepAspectRatio : true,
					verticalRatio : 0.5
				};

				var camera = graph ? graph.getCameraPosition() : null;

				// create our graph
				var container = document.getElementById('mygraph');
				graph = new vis.Graph3d(container, data, options);

				if (camera)
					graph.setCameraPosition(camera);
				// restore camera position


			}
		</script>

	</body>
</html>