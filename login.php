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
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">
							Sign In
						</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px">
							<a href="#">Forgot password?</a>
						</div>
					</div>

					<div style="padding-top:30px" class="panel-body" >

						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

						<form id="loginform" class="form-horizontal" role="form">

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
							</div>

							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="login-password" type="password" class="form-control" name="password" placeholder="password">
							</div>

							<div class="input-group">
								<div class="checkbox">
									<label>
										<input id="login-remember" type="checkbox" name="remember" value="1">
										Remember me </label>
								</div>
							</div>

							<div style="margin-top:10px" class="form-group">
								<!-- Button -->

								<div class="col-sm-12 controls">
									<a id="btn-login" href="#" class="btn btn-success">Login </a>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Don't have an account yet?
										<a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()"> Sign Up Here </a>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">
							Sign Up
						</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px">
							<a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a>
						</div>
					</div>
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form">

							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>
									Error:
								</p>
								<span></span>
							</div>

							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Username</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="username" placeholder="Username">
								</div>
							</div>

							<div class="form-group">
								<label for="firstname" class="col-md-3 control-label">First Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="firstname" placeholder="First Name">
								</div>
							</div>
							<div class="form-group">
								<label for="lastname" class="col-md-3 control-label">Last Name</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="lastname" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="passwd" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Verify Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="verify_passwd" placeholder="Verify Password">
								</div>
							</div>

							<div class="form-group">
								<!-- Button -->
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-signup" type="button" class="btn btn-info">
										<i class="icon-hand-right"></i> &nbsp Sign Up
									</button>
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