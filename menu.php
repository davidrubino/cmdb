<?php

echo '<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar" class="navbar-collapse collapse" role="navigation">
			<ul class="nav navbar-nav" id="#menu">
				<li>
					<a href="home.php">Home</a>
				</li>
				<li>
					<a href="ci.php">Configuration Items</a>
				</li>
				<li>
					<a href="app.php">Applications</a>
				</li>
				<li>
					<a href="dataCenter.php">Data Center</a>
				</li>
				<li>
					<a href="hr.php">Human Resources</a>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<form class="navbar-form" role="search">
		                <div class="input-group">
		                    <input type="text" class="form-control" placeholder="Search" name="q">
		                    <div class="input-group-btn">
		                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		                    </div>
		                </div>
	            	</form>
				</li>
				<li class="dropdown">
					<a data-toggle="dropdown" href="#">Settings
          				<span class="caret"></span>
          			</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="accountInfo.php">Account information</a>
						</li>
						<li>
							<a href="#">Open configuration</a>
						</li>
						<li>
							<a href="#">Snapshot database</a>
						<li>
							<a href="logout.php?logout=true">Log Out</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>';
?>