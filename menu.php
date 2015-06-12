<?php
echo '<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav" id="#menu">
          	<li><a href="index.php">Home</a></li>
            <li><a href="configItem.php">Configuration Items</a></li>
            <li><a href="app.php">Applications</a></li>
            <li><a href="dataCenter.php">Data Center</a></li>
            <li><a href="hr.php">Human Resources</a></li>
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
          	<li class="dropdown">
              <img class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" src="img/menu-icon.png"><span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>Account information</a></li>
                <li>Open configuration</a></li>
                <li>Sign out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>';
?>