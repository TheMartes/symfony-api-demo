#!/bin/sh
mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON *.* TO 'root@localhost IDENTIFIED BY 'root';"
mysql -u ${MYSQL_USER} -p${MYSQL_PASSWORD} <app.sql
mysql -u ${MYSQL_USER} -p${MYSQL_PASSWORD} <company.sql
