<?php
session_start();
if(!file_exists('../users/' . $_SESSION['username'] . '.xml') || empty($_SESSION['username'])){
    header('Location: login.php');
    die;
}
require 'config.php';
$message = '';
// Control Switch
if(isset($_GET['action'])){
	switch($_GET['action']) {
		// Apache Control
		case "start_apache":
			$outputShell = shell_exec("sudo /sbin/service httpd start");
			if($outputShell == NULL) {
				$message = "ERROR: Apache could not be started.";
			} else {
				$message = "Apache has been started.";
			}
		break;
		case "stop_apache":
			$outputShell = shell_exec("sudo /sbin/service httpd stop");
			if($outputShell == NULL) {
				$message = "ERROR: Apache could not be stopped.";
			} else {
				$message = "Apache has been stopped.";
			}
		break;
		case "restart_apache":
			$outputShell = shell_exec("sudo /sbin/service httpd restart");
			if($outputShell == NULL) {
				$message = "ERROR: Apache could not be restarted.";
			} else {
				$message = "Apache has been restarted.";
			}
		break;
		// MySQL Control
		case "start_mysqld":
			$outputShell = shell_exec("sudo /sbin/service mysqld start");
			if($outputShell == NULL) {
				$message = "ERROR: MySQL could not be started.";
			} else {
				$message = "MySQL has been started.";
			}
		break;
		case "stop_mysqld":
			$outputShell = shell_exec("sudo /sbin/service mysqld stop");
			if($outputShell == NULL) {
				$message = "ERROR: MySQL could not be stop.";
			} else {
				$message = "MySQL has been stop.";
			}
		break;
		case "restart_mysqld":
			$outputShell = shell_exec("sudo /sbin/service mysqld restart");
			if($outputShell == NULL) {
				$message = "ERROR: MySQL could not be restarted.";
			} else {
				$message = "MySQL has been restarted.";
			}
		break;		
		// SSH Control
		case "start_sshd":
			$outputShell = shell_exec("sudo /sbin/service sshd start");
			if($outputShell == NULL) {
				$message = "ERROR: SSH could not be started.";
			} else {
				$message = "SSH has been started.";
			}
		break;
		case "stop_sshd":
			$outputShell = shell_exec("sudo /sbin/service sshd stop");
			if($outputShell == NULL) {
				$message = "ERROR: SSH could not be stopped.";
			} else {
				$message = "SSH has been stopped.";
			}
		break;
		case "restart_sshd":
			$outputShell = shell_exec("sudo /sbin/service sshd restart");
			if($outputShell == NULL) {
				$message = "ERROR: SSH could not be restarted.";
			} else {
				$message = "SSH has been restarted.";
			}
		break;
		// Sendmail Control
		case "start_sendmail":
			$outputShell = shell_exec("sudo /sbin/service sendmail start");
			if($outputShell == NULL) {
				$message = "ERROR: Sendmail could not be started.";
			} else {
				$message = "Sendmail has been started.";
			}
		break;
		case "stop_sendmail":
			$outputShell = shell_exec("sudo /sbin/service sendmail stop");
			if($outputShell == NULL) {
				$message = "ERROR: Sendmail could not be stopped.";
			} else {
				$message = "Sendmail has been stopped.";
			}
		break;
		case "restart_sendmail":
			$outputShell = shell_exec("sudo /sbin/service sendmail restart");
			if($outputShell == NULL) {
				$message = "ERROR: Sendmail could not be restarted.";
			} else {
				$message = "Sendmail has been restarted.";
			}
		break;	
		// Default Break
		default:
		break;
	}
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
					<li><a href="index.php" class="active">Overview</a></li>				
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
					<h2>Service Monitor and Control</h2>
					<p>View the <a href="help-files.php#servicemonitor">help </a>file for this section.</p>
				</div>
					
	<!--Monitors -->
	
		<div class="in">			
			<table width="100%" border="0" cellspacing="0" cellpadding="10" class="table_main" >
			  <tr style="background-color:#d9d8d8; font-size:14px;">
				<td width="64%"><strong>SERVICE MONITOR</strong></td>
				<td width="13%"><strong>STATUS</strong></td>			
				<td width="23%"><strong>SERVER CONTROLS</strong></td>
			  </tr>
			  <tr class="gray">
			  <!-- Apache Control -->
				<td>Apache</td>
				<td>			
				<?php  
				$connection = @fsockopen("127.0.0.1", $apache_port, $errno, $errstr, 2);  
				if ($connection) {  
					echo "<font color=#f7941d>Online</font>";  
					fclose($connection);  
				} else {  
					echo "<font color=#b3b3b3>Offline</font>";  
				}
				?>				
				</td>
				<td>
				<a href="index.php?action=start_apache">START </a><span class="v_line">| <a href="index.php?action=stop_apache">STOP </a><span class="v_line">| </span> <a href="index.php?action=restart_apache">RESTART </a></td>
			  </tr>
			  <tr>
			  <!-- MySQL Control -->
				<td>MySQL</td>
				<td>
				<?php  
				$connection = @fsockopen("127.0.0.1", $mysql_port, $errno, $errstr, 2);  
				if ($connection) {  
					echo "<font color=#f7941d>Online</font>";  
					fclose($connection);  
				} else {  
					echo "<font color=#b3b3b3>Offline</font>";  
				}
				?>				
				</td>			
				<td><a href="index.php?action=start_mysqld">START </a><span class="v_line">| <a href="index.php?action=stop_mysqld">STOP </a><span class="v_line">| </span> <a href="index.php?action=restart_mysqld">RESTART </a></td>
			  </tr>
			  <tr class="gray">
			  <!-- SSH Control -->
				<td>SSH</td>
				<td>
				<?php  
				$connection = @fsockopen("127.0.0.1", $ssh_port, $errno, $errstr, 2);  
				if ($connection) {  
					echo "<font color=#f7941d>Online</font>";  
					fclose($connection);  
				} else {  
					echo "<font color=#b3b3b3>Offline</font>";  
				}
				?>				
				</td>			
				<td><a href="index.php?action=start_sshd">START </a><span class="v_line">| <a href="index.php?action=stop_sshd">STOP </a><span class="v_line">| </span> <a href="index.php?action=restart_sshd">RESTART </a></td>
			  </tr>
			   <tr>
			   <!-- Sendmail Control -->
				<td>Sendmail</td>
				<td>
				<?php  
				$connection = @fsockopen("127.0.0.1", $sendmail_port, $errno, $errstr, 2);  
				if ($connection) {  
					echo "<font color=#f7941d>Online</font>";  
					fclose($connection);  
				} else {  
					echo "<font color=#b3b3b3>Offline</font>";  
				}
				?>				
				</td>			
				<td><a href="index.php?action=start_sendmail">START	</a><span class="v_line">| <a href="index.php?action=stop_sendmail">STOP </a><span class="v_line">| </span> <a href="index.php?action=restart_sendmail"> RESTART</a></td>
			  </tr>
			</table>
		<?php if($message){ echo "<br><strong><font color=#ff0000>". $message ."</font></strong>";} ?>
		</div>			
				
	<!--Monitors -->		
		<div class="in minitext">
			<h2>Server Information</h2>
				<p>View the <a href="help-files.php#serverinformation">help </a>file for this section.</p><br />		
			
			<?php
			$outputShell = shell_exec("../scripts/server-info.sh");
			echo "<pre>$outputShell</pre>";
			?>

		</div>
	
		</div><!-- content -->
		
		<p class="footer">&copy; BoxCtrl-SE</p>
	</div><!-- Wrapper -->
</body>
</html>