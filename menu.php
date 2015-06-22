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
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="configItem.php">Configuration Items</a>
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
				<li class="dropdown">
					<span class="glyphicon glyphicon-menu-hamburger glyphicon-large" data-toggle="dropdown" role="button" aria-expanded="false" aria-hidden="true"></span>
					<ul class="dropdown-menu" role="menu">
						<li>
							Account information</a>
						</li>
						<li>
							Open configuration</a>
						</li>
						<li>
							Sign out</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>';
?>