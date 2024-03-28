#!/bin/bash

/opt/lampp/bin/mysql < /opt/lampp/htdocs/ressources/gestion_cabinet_app.sql

cat /opt/lampp/htdocs/ressources/conf >> /opt/lampp/etc/httpd.conf
