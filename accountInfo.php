<?php

include 'db_connect.php';

if (!$user -> is_loggedin()) {
	$user -> redirect('login.php');
}

$user_id = $_SESSION['user_session'];

try {
	$sql = 'select user_name, user_email, user_fname, user_lname, isAdmin
				from user
				where user_id = :user_id;';

	$stmt = $DB_con -> prepare($sql);
	$stmt -> execute(array(':user_id' => $user_id));
	$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	$string = json_encode($row);
	$decoded_json = json_decode($string, true);

} catch(PDOException $e) {
	echo json_encode(['success' => 'no', 'message' => 'error while loading']);
}

if (isset($_POST['btn-save'])) {
	$uname = $decoded_json[0]['user_name'];
	$upass = trim($_POST['txt_password']);
	$upass_check = trim($_POST['txt_password_confirm']);

	if ($upass == "") {
		$error[] = "Please provide a password!";
	} else if (strlen($upass) < 6) {
		$error[] = "Password must be at least 6 characters!";
	} else if ($upass != $upass_check) {
		$error[] = "Passwords do not match!";
	} else {
		try {
			if ($user -> changePassword($uname, $upass)) {
				$user -> redirect('home.php');
			}
		} catch(PDOException $e) {
			echo $e -> getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Account Information</title>

		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/menu.css" rel="stylesheet">

	</head>

	<body>

		<?php
		include 'menu.php';
		?>

		<div class="container">
			<div style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info" >
					
					<div class="panel-heading">
						<div class="panel-title" id="full-name">
							<?php echo $decoded_json[0]['user_fname'] . " " . $decoded_json[0]['user_lname']; ?>
						</div>
					</div>

					<div style="padding-top:30px" class="panel-body" >
						
						<?php
if(isset($error)) {
foreach($error as $error) {
						?>
						<div class="alert alert-danger">
							<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
						</div>
						<?php
						}
						}
						?>
						
						<div class="table-responsive">
							<form class="form-horizontal" role="form" method="post">
							<table class="table table-bordered table-hover">
								<tbody>
									<tr>
										<td><strong>Username</strong></td>
										<td><?php echo $decoded_json[0]['user_name']; ?></td>
									</tr>
									<tr>
										<td><strong>Admin</strong></td>
										<td><?php echo $decoded_json[0]['isAdmin']; ?></td>
									</tr>
									<tr>
										<td><strong>Email</strong></td>
										<td><?php echo $decoded_json[0]['user_email']; ?></td>
									</tr>
									<tr>
										<td><strong>Password</strong></td>
										<td><a href="#" class="toggler">change password</a>
											<span class="cat1" style="display:none">
											<hr>
											<input type="password" class="form-control" name="txt_password" placeholder="New password">
											<br>
											<input type="password" class="form-control" name="txt_password_confirm" placeholder="Confirm password">
											</span>
										</td>
									</tr>
								</tbody>
							</table>
							</form>

							<div class="btn-group" style="display:none">
								<div class="col-sm-12 controls">
									<button type="submit" name="btn-save" class="btn btn-large btn-primary">
										Save settings
									</button>
									<button type="submit" name="btn-cancel" class="btn btn-large btn-default">
										Cancel
									</button>
								</div>
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
		<script src="menu.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$(".toggler").click(function(e) {
					e.preventDefault();
					$('.cat1').toggle();
					$('.btn-group').toggle();
				});
			});
		</script>

	</body>
</html>