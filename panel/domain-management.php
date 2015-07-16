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
					<li><a href="domain-management.php" class="active">Domain Management</a></li>									
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
					<h2>Domain Management</h2>
					<p>View the <a href="help-files.php#domainmanagement">help </a>file for this section.</p>
				</div>
				<div class="in">
				<p><b>NOTE:</b> Separate multiple domains with a space. Do not use commas. (example: test.com test2.com test3.com)</p>
				<?php
				if (@!$_POST['submit'])
				{
				//Form not submitted, display form
				?>
				<form action="<?php echo @$SERVER['PHP_SELF']; ?>"
				method="post">
				<br />
				<input name="textinputs" maxlength="80" class="box"></input>
				<br /><br />
				<input type="submit" name="submit" value="Add New Domain(s)" class="com_btn">
				</form>
				<?php
				}
				else
				{
				//Form submitted, grab the data from POST
				$textinputs =trim($_POST['textinputs']);
				//Test if it contains some data.
				if (!isset($textinputs) || trim($textinputs) == "")
				{
				//Feedback to user that it contains no data
				die ('<strong><font color=#ff0000>ERROR - NO DATA INPUT</font></strong>');
				}
				else
				{
				//Set file to write
				$filepath='/srv/www/control/domain.new';
				//Open file in writing mode
				$filehandler= fopen($filepath, 'w') or die('ERROR: Domain File Not Added');
				//write text to file
				fwrite($filehandler,$textinputs) or die('ERROR: Domain File Not Added');
				//Close file
				fclose($filehandler);
				echo '<br /><br /><b>Your new domain(s) will be added within 60 seconds.</b><br /><br />Please upload your site to the /home/domains/YOURNEWDOMAIN.COM/www folder so it will be viewable from a web browser.<br /><br />';
				}
				}
				?>				
				</div>	

				<div class="in minitext">
					<h2>Current Domains</h2>
				</div>
				<div class="in">
				<div class="domains">
				<ul>
				<?php
				$dir = "/home/domains";
				$handle = opendir($dir);
				while($name = readdir($handle)) {
					if(is_dir("$dir/$name")) {
						if($name != '.' && $name != '..') {
							echo "<li><a href='http://$name'>$name</a></li>";
						}
					}
				}
				closedir($handle);
				?>
				</ul>
				</div>
				</div>				
	
		</div><!-- content -->
		
		<p class="footer">&copy; BoxCtrl-SE</p>
	</div><!-- Wrapper -->
</body>
</html>