#!/bin/bash
clear

## Check for root
if [ $(id -u) != "0" ]; then
    echo "You must be the root to run this install script." >&2
    exit 1
fi

## Check for 32-bit OS
if [ `uname -i` == x86_64 ]; then
    echo "BoxCtrl must be installed on a CentOS 32-bit." >&2
    exit 1
fi

## Check for CentOS
os=`cat /etc/redhat-release | grep -i cent`
if [ "$?" -ne "0" ]; then
	echo "BoxCtrl can only be installed on CentOS."
	exit 1;
fi

# Check for YUM
if ! [ -f /usr/bin/yum ] ; then
	echo "YUM must be installed to continue."
	exit 1;
fi

## Welcome message
cat <<EOF
######################################
Only install BoxCtrl on a clean OS. If this is not a clean install of CentOS 32-bit, do not continue. Now that you've read the warning, 
are you ready to install BoxCtrl? Type "yes" or "no".
######################################
EOF

read useranswer

if [ "$useranswer" == "yes" ];
then
	echo "Installation starting..."
	sleep 2
else
	echo "Installation stopped."
	exit
fi

## Check for existing installation
if [ -f /srv/www/control/master-control.sh ]
then
	echo "You already have the panel installed. Exiting now."
	exit
fi  

## Check for lighttpd installation
if [ -f /etc/lighttpd/lighttpd.conf ] 
then
	echo "It looks like you already have lighttpd installed. BoxCtrl can't be installed on your system if you already use Lighttpd. Stopping installation."
	exit
else
	wget http://packages.sw.be/rpmforge-release/rpmforge-release-0.3.6-1.el5.rf.i386.rpm
	rpm -Uvh rpmforge-release-0.3.6-1.el5.rf.i386.rpm
	yum -y install lighttpd
	chkconfig --levels 235 lighttpd on
	rm -f rpmforge-release-0.3.6-1.el5.rf.i386.rpm
	mv -f files/fastcgi.conf /etc/lighttpd/conf.d
	mv -f files/lighttpd.conf /etc/lighttpd/
	mv -f files/modules.conf /etc/lighttpd/
fi

## Install php-cgi for lighttpd
yum -y install lighttpd-fastcgi php-cli

## Install apache if needed
yum -y install httpd
yum -y install php

## Move httpd.conf and php.ini - backup old - make domains folder
mv /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.BACKUP
mv /etc/php.ini /etc/php.ini.BACKUP
mv files/httpd.conf /etc/httpd/conf/
mv files/php.ini /etc/
mkdir /home/domains/

## Install mysql
yum -y install mysql mysql-server php-mysql

## Setup the panel folders
mkdir /srv/www/panel
mkdir /srv/www/control
mkdir /srv/www/blocked
mkdir /srv/www/users
mkdir /srv/www/scripts
rm -fr /srv/www/lighttpd

## Get master control and setup cron / admin notes
touch /etc/cron.d/boxctrl
echo "* * * * * root /srv/www/control/master-control.sh > /dev/null 2>&1" >> /etc/cron.d/boxctrl
echo "0 * * * * root /srv/www/control/cleanup.sh > /dev/null 2>&1" >> /etc/cron.d/boxctrl

## Setup vnstat
yum -y install vnstat
vnstat -u -i venet0
echo "*/5 * * * * root /usr/sbin/vnstat.cron > /dev/null 2>&1" > /etc/cron.d/vnstat
echo 'VNSTAT_OPTIONS="-i venet0"' > /etc/sysconfig/vnstat

## Setup sysstat
yum -y install sysstat

## Move the panel files
mv panel /srv/www/
mv users /srv/www/
mv control /srv/www/
mv scripts /srv/www/
rm -fr files
rm -fr blocked

## Create BoxCtrl user
useradd -M -s /sbin/nologin boxctrl

## Chown and chmod settings
chown -R boxctrl:boxctrl /srv/www
chown -R boxctrl:boxctrl /var/log/lighttpd
chmod +x /srv/www/control/master-control.sh
chmod +x /srv/www/control/cleanup.sh
chmod +x /srv/www/scripts/server-info.sh

## Edit /etc/sudoers
sed -i 's/^Defaults    requiretty/# Defaults    requiretty/g' /etc/sudoers
echo "boxctrl ALL=(ALL) NOPASSWD: /sbin/service" >> /etc/sudoers

## Leave this to help BoxCtrl record installation stats
wget http://boxctrl.com/stats/installstats.php
rm -fr installstats.php

## Start the server
/etc/init.d/lighttpd start
/etc/init.d/httpd restart
clear

## Installation complete
cat <<EOF
######################################
Default Username: admin
Default Password: boxctrlpass

NOTE: If you did not already have MySQL installed, BoxCtrl installed it for you. Please start the MySQL service and run the command
"/usr/bin/mysql_secure_installation" to secure MySQL. The MySQL username is "root" and the password is blank.

EOF

name=`hostname -i`
echo 'BoxCtrl login URL: http://'$name':2010'
echo '######################################'

exit