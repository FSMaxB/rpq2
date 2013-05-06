#!/bin/sh
USER=$1
GROUP=$2
chown -R $USER:$GROUP regler csv einstell owndocs tty-logs tmp
chmod -R a+r bilder docs
