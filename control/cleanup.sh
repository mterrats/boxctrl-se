#!/bin/bash

## kill old processes
kill -9 `ps -ef | grep master-control | grep -v grep | awk '{print $2}'`

## empty the blocked ip list
find /srv/www/blocked -type f -delete