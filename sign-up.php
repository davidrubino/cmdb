<?php

require_once 'db_connect.php';

if ($user -> is_loggedin() != "") {
	$user -> redirect('home.php');
}

if (isset($_POST['btn-signup'])) {
	$uname = trim($_POST['txt_uname']);
	$umail = trim($_POST['txt_umail']);
	$upass = trim($_POST['txt_upass']);
	$upass_check = trim($_POST['txt_upass_check']);
	$fname = trim($_POST['txt_fname']);
	$lname = trim($_POST['txt_lname']);
	$isAdminValue = trim($_POST['select_isAdmin']);
	$isAdmin = filter_var($isAdminValue, FILTER_VALIDATE_BOOLEAN);

	if ($uname == "") {
		$error[] = "Please provide a username!";
	} else if ($umail == "") {
		$error[] = "Please provide an email address!";
	} else if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Please enter a valid email address!';
	} else if ($upass == "") {
		$error[] = "Please provide a password!";
	} else if (strlen($upass) < 6) {
		$error[] = "Password must be at least 6 characters!";
	} else if ($upass != $upass_check) {
		$error[] = "Passwords do not match!";
	} else if ($fname == "") {
		$error[] = "Please provide your first name!";
	} else if ($lname == "") {
		$error[] = "Please provide your last name!";
	} else {
		try {
			$stmt = $DB_con -> prepare("SELECT user_name,user_email FROM user WHERE user_name=:uname OR user_email=:umail");
			$stmt -> execute(array(':uname' => $uname, ':umail' => $umail));
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);

			if ($row['user_name'] == $uname) {
				$error[] = "Username already taken!";
			} else if ($row['user_email'] == $umail) {
				$error[] = "Email already taken!";
			} else {
				if ($user -> register($fname, $lname, $uname, $umail, $upass, $isAdmin)) {
					$user -> redirect('home.php');
				}
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

		<title>Data Center</title>

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
							Sign Up
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

						<form class="form-horizontal" role="form" method="post">

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php
								if (isset($error)) {echo $uname;
								}
								?>" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail" value="<?php
								if (isset($error)) {echo $umail;
								}
								?>" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="txt_upass_check" placeholder="Confirm Password" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="txt_fname" placeholder="Enter First Name" value="<?php
								if (isset($error)) {echo $fname;
								}
								?>" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" class="form-control" name="txt_lname" placeholder="Enter Last Name" value="<?php
								if (isset($error)) {echo $lname;
								}
								?>" />
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon">Admin?</span>
								<select class="form-control" name="select_isAdmin">
									<option value="true">Yes</option>
									<option value="false">No</option>
								</select>
							</div>

							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button type="submit" name="btn-signup" class="btn btn-block btn-primary" >
										<i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP
									</button>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Already have an account?
										<a href="login.php">Log In</a>
									</div>
								</div>
							</div>

						</form>
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

	</body>
</html>