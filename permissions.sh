#!/bin/sh
USER=$1
GROUP=$2
chown -R root:root ./
chown -R $USER:$GROUP einstell-mess docs wartung log pdo
chown $USER:$GROUP settings.cfg
find -type d -exec chmod 755 {} \;
find -type f -exec chmod 644 {} \;
find -name "*.sh" -exec chmod a+x {} \;
chmod a+x nativ/einstell nativ/test
