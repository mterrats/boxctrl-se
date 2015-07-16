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
					<h2>BoxCtrl-SE Basics</h2>
				</div>
				<div class="in">			
				BoxCtrl-SE is a basic server administration panel for Linux. It was developed to be fast and use minimal resources (almost entirely text based (one only image file) and only uses around 10MB of RAM), while allowing users web-based access to a few key tasks. It uses Lighttpd, PHP, XML (no MySQL needed), bash scripts and cron jobs to do everything. It's meant to be a quick alternative to SSH when you need to do something simple, like restart a service.
				</div>			

				<div class="in minitext">
					<a name="changepassword"></a><h2>Changing Your Password</h2>
				</div>
				<div class="in">			
				The "Change Password" page allows you to change your user password. You can also change your username or add additional users by adding/editing .xml files in the "users" folder. Do not edit or create files unless you know what you are doing.
				</div>	
				
				<div class="in minitext">
					<a name="servicemonitor"></a><h2>Service Monitor and Control</h2>
				</div>
				<div class="in">			
				The "Service Monitor and Control" section allows you to start/stop/restart Apache, MySQL, SSH, and Sendmail without having to connect via SSH. After clicking on one of the control links, BoxCtrl will set a cron that will execute the command within 60 seconds. If one of your services runs on a non-standard port, BoxCtrl will always report the service as being offline. You can fix this buy changing the service port listed in the config.php file.
				</div>	
				
				<div class="in minitext">
					<a name="serverinformation"></a><h2>Server Information</h2>
				</div>
				<div class="in">			
				The "Server Information" section gives you some basic information, like: hostname, kernel version, php version, mysql version, apache version, cpu make and information, free and used memory, filesystem information, date, uptime and cpu load.
				</div>				
				
				<div class="in minitext">
					<a name="domainmanagement"></a><h2>Domain Management</h2>
				</div>
				<div class="in">			
				BoxCtrl uses a special Apache configuration that allows for wildcard entries. When you add a new domain, a new folder will be created in the "/home/domains" directory with the name of your domain. Any folder in this directory with a domain as a name will automatically be resolved by Apache. Folders are literal, meaning a subdomain of "www" must be entered if you want your site to use "www" in front of the domain (example: enter "www.example.com" and not "example.com"). If you need to give a site a dedicated IP, you will need to manually add the entry to the end of the Apache configuration file yourself.
				</div>						

				<div class="in minitext">
					<a name="databasemanagement"></a><h2>Database Management</h2>
				</div>
				<div class="in">			
				BoxCtrl includes the lightweight alternative to phpMyAdmin, <a href="http://www.adminer.org">Adminer</a>, for database management. It can be separately configured and upgraded on its own (visit the site for a list of plugins). Remember to login with your *mysql* user information, not SSH or BoxCtrl user information.
				</div>	
				
				<div class="in minitext">
					<a name="filemanager"></a><h2>File Manager</h2>
				</div>
				<div class="in">			
				BoxCtrl includes a copy of <a href="http://www.solitude.dk/filethingie">File Thingie</a> for file management. It is a separate script that can be edited on its own via the index file in the "file-manager" folder. See the File Thingie site for more information on how to use it (a &loz; means you can edit something and a dash means you can't). If you would like to use a different file manager script, just delete the files in the "file-manager" folder and replace them with the script you want. In order to edit files you must chown them to the "boxctrl" user.
				</div>	
				
				<div class="in minitext">
					<a name="runningprocesses"></a><h2>Running Processes</h2>
				</div>
				<div class="in">			
				The "Running Processes" page simply lists all of the currently running processes on your server.
				</div>	

				<div class="in minitext">
					<a name="cpulog"></a><h2>CPU Log</h2>
				</div>
				<div class="in">			
				The "CPU Log" page uses sysstat to take a detailed recording of your CPU usage since midnight that day. This page updates every ten minutes and resets at midnight.
				</div>	

				<div class="in minitext">
					<a name="memorylog"></a><h2>Memory Log</h2>
				</div>
				<div class="in">			
				The "Memory Log" page uses sysstat to take a detailed recording of your memory usage since midnight that day. This page updates every ten minutes and resets at midnight.
				</div>	

				<div class="in minitext">
					<a name="trafficusage"></a><h2>Traffic Usage</h2>
				</div>
				<div class="in">			
				The "Traffic Usage" page uses vnstat to record your inbound and outbound network traffic. It displays usage in a summary since it first started recording, daily (for the last 30 days), and for the last hour. It is configured to listen on venet (for OpenVZ VPS containers). If you are using BoxCtrl on a dedicated server that uses eth0 as its network device, you need to reconfigure vnstat. See "man vnstat" from the console or <a href="http://humdi.net/vnstat/man/vnstat.html">here</a> for more information.
				</div>	

				<div class="in minitext">
					<a name="installedpackages"></a><h2>Installed Packages</h2>
				</div>
				<div class="in">			
				The "Installed Packages" page is a list of everything you have installed on your system via YUM. You can update all of the packages (that have an update available) from this page. The update process could take a long time, depending on your last update and system resources. It's a good idea to not run this more than once a day.
				</div>					
		</div><!-- content -->
		
		<p class="footer">&copy; BoxCtrl-SE</p>
	</div><!-- Wrapper -->
</body>
</html>