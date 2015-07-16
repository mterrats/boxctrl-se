#!/bin/bash
clear

if [ $(id -u) != "0" ]; then
    echo "You must be the root to run this uninstall script." >&2
    exit 1
fi

cat <<EOF
######################################
This uninstall script will remove apache (files in /home will not be removed), mysql, php, vnstat, sysstat, lighttpd and all BoxCtrl related files. You can 
choose to keep things like MySQL installed by editing this uninstall script and commenting out specific lines. Make sure you backup all needed files before 
running this script. If you are ready to uninstall, type "yes". Otherwise, type "no".
######################################
EOF

read useranswer

if [ "$useranswer" == "yes" ];
then
	echo "Uninstall starting..."
	sleep 2
else
	echo "Uninstall stopped."
	exit
fi

## remove folders and files

rm -fr /srv/www
rm /etc/cron.d/boxctrl
yum -y remove sysstat
yum -y remove lighttpd
yum -y remove lighttpd-fastcgi
yum -y remove php-cli
yum -y remove httpd
yum -y remove php
yum -y remove mysql
yum -y remove mysql-server
yum -y remove php-mysql
yum -y remove vnstat
yum -y remove sysstat

## remove boxctrl user
userdel -r boxctrl
sed -i '/boxctrl/d' /etc/sudoers

## uninstall complete
clear
echo "BoxCtrl has been uninstalled."
exit