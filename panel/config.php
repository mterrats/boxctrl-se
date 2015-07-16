<?php

// The number of failed login attempts before blocking the IP of the user. Blocked IPs are cleared every 60 minutes.
$failed_attempts = 3;

// Port numbers that the service monitor should check on.
$apache_port = 80;
$mysql_port = 3306;
$ssh_port = 22;
$sendmail_port = 25;

?>