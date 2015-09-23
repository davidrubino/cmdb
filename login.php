<?php
require_once 'db_connect.php';

if ($user -> is_loggedin() != "") {
	$user -> redirect('home.php');
}

if (isset($_POST['btn-login'])) {
	$uname = $_POST['txt_uname_email'];
	$umail = $_POST['txt_uname_email'];
	$upass = $_POST['txt_password'];

	if ($user -> login($uname, $umail, $upass)) {
		$user -> redirect('home.php');
	} else {
		$error = "Login and password do not match!";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Login</title>

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
						<div class="panel-title">
							Log In
						</div>
					</div>

					<div style="padding-top:30px" class="panel-body" >

						<?php
if(isset($error))
{
						?>
						<div class="alert alert-danger">
							<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
						</div>
						<?php
						}
						?>

						<form class="form-horizontal" role="form" method="post">

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="txt_uname_email" placeholder="username or email">
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="txt_password" placeholder="password">
							</div>

							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button type="submit" name="btn-login" class="btn btn-block btn-primary">
										<i class="glyphicon glyphicon-log-in"></i>&nbsp;LOG IN
									</button>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Don't have an account yet?
										<a href="sign-up.php">Sign Up</a>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>

		<script src="jquery/jquery-1.11.3.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="menu.js"></script>

	</body>
</html>