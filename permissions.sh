#!/bin/sh
USER=$1
GROUP=$2
chown -R $USER:$GROUP regler csv einstell owndocs tty-logs tmp
find -type d -exec chmod 755 {} \;
#find -type f -exec chmod 644 {} \;
find -name "*.sh" -exec chmod a+x {} \;
chmod -R a+r bilder docs
