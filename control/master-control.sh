#!/bin/bash

#YUM Update Check
if test -f /srv/www/control/update_yum.now
then
rm -f /srv/www/control/update_yum.now
yum clean all ; yum -y update
fi

#New Domain Check
if test -f /srv/www/control/domain.new
then
	domain=`cat /srv/www/control/domain.new`
	for i in $domain; do
	mkdir /home/domains/$i
	mkdir /home/domains/$i/www
	echo "Your domain is active." > /home/domains/$i/www/index.html
	rm -f /srv/www/control/domain.new
	chown -R boxctrl:boxctrl /home/domains/$1
	done
fi

exit