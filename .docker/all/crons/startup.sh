#!/bin/sh

echo "Starting startup.sh.."
echo "*/2       *       *       *       *       run-parts /etc/periodic/2min" >> /etc/crontabs/root
crontab -l
