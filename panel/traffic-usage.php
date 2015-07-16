<?php
session_start();
if(!file_exists('../users/' . $_SESSION['username'] . '.xml') || empty($_SESSION['username'])){
    header('Location: login.php');
    die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>BoxCtrl-SE</title>
<link rel="stylesheet" type="text/css"  href="css/main.css" />
</head>

<body>

	<div class="wrapper"><!-- Wrapper -->
	
		<h1 class="logo"><img src="images/logo.png" /></h1>
		<p class="txt_right">Logged in as <strong><?php echo $_SESSION['username']; ?></strong>  <span class="v_line"> | </span> <a href="change-password.php">Change Password</a> <span class="v_line"> | </span> <a href="logout.php"> Logout</a></p>
	
	<!-- Navigation -->
	
		<div class="navigation">
				<ul>
					<li><a href="index.php">Overview</a></li>				
					<li><a href="domain-management.php">Domain Management</a></li>									
					<li><a href="database-management.php">Database Management</a></li> <!-- usage " class="active" " for color -->
					<li><a href="file-manager.php">File Manager</a></li>	
					<li><a href="help-files.php">Help Files</a></li>										
				</ul>			
		</div>
		
		<div class="clear"></div>
	
	
		<div class="content"><!-- content -->
		
	<!-- Subnav -->
	
		<div class="toplinks">	
				<ul>		

					<li><a href="running-processes.php"><strong>Running Processes</strong></a></li>
					<li><a href="cpu-log.php"><strong>CPU Log</strong></a></li>
					<li><a href="memory-log.php"><strong>Memory Log</strong></a></li>
					<li><a href="traffic-usage.php"><strong>Traffic Usage</strong></a></li>	
					<li><a href="installed-packages.php"><strong>Installed Packages</strong></a></li>											
				</ul>	
		</div>
		
				<div class="in minitext">
					<h2>Traffic Usage Summary</h2>
					<p>View the <a href="help-files.php#trafficusage">help </a>file for this section.</p>
				</div>
				<div class="in">			
				<?php
				$output = shell_exec('vnstat');
				echo "<pre>$output</pre>";
				?>
				</div>	
				
				<div class="in minitext">
					<h2>Traffic Usage Daily</h2>
				</div>
				<div class="in">				
				<?php
				$output = shell_exec('vnstat -d');
				echo "<pre>$output</pre>";
				?>
				</div>	
				
				<div class="in minitext">
					<h2>Traffic Usage Hourly</h2>
				</div>
				<div class="in">			
				<?php
				$output = shell_exec('vnstat -h');
				echo "<pre>$output</pre>";
				?>
				</div>					
	
		</div><!-- content -->
		
		<p class="footer">&copy; BoxCtrl-SE</p>
	</div><!-- Wrapper -->
</body>
</html>