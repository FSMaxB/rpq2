#!/bin/sh

# Dieses Skript dient dem Weiterleiten des Webinterfaces per SSH-Forwarding zu einem anderen Computer

if [ $1 ]
then
    USER=$1
    HOST=$2
    if [ $3 ]
    then
        IDENTITY=$3
        ssh -N -i $IDENTITY -R $HOST:8080:localhost:80 $USER@$HOST
    else
        ssh -N -R $HOST:8080:localhost:80 $USER@$HOST
    fi
else
    echo "Benutzung: $0 nutzer zielserver private-key"
fi

