<?php

include 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Show applications</title>

		<link href="jquery/jquery-ui.min.css" rel="stylesheet">

	</head>

	<body>
		<div id="dialog" title="Applications">
			I'm in a dialog
		</div>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="jquery/jquery-ui.js"></script>
		
		<script type="text/javascript">
			function loadPage(dapage) {
				opener.location.href = dapage;
			}

			$(document).ready(function() {
				$("#dialog").dialog();
			});
		</script>

	</body>
</html>