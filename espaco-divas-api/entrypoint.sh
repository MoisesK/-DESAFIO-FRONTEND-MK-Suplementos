#!/bin/bash

cd /app

chmod -R 777 /app/storage

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
