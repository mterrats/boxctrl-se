#!/bin/bash
echo ""
echo "=========================================================================="
echo -n "Hostname: "
hostname
uname -srm
echo ""
echo -n "PHP version: "
/usr/bin/php -nv | grep built | cut -d " " -f2
echo -n "MySQL version: "
/usr/bin/mysql -V | cut -d " " -f6 | cut -d "," -f1
echo -n "Apache version: "
/usr/sbin/httpd -v | grep version | cut -d "/" -f2
echo -n "CPU number: "
cat /proc/cpuinfo | grep -c "processor"
echo "--------------------------------------------------------------------------"
echo "Memory: used       free (MB)"
free -m | grep buffers/ca | cut -d":" -f2
echo "--------------------------------------------------------------------------"
df -h
echo "--------------------------------------------------------------------------"
uptime
echo "=========================================================================="