#!/bin/sh

# Dieses Skript dient dem Weiterleiten des Webinterfaces per SSH-Forwarding zu einem anderen Computer

if [ $1 ]
then
    USER=$1
    HOST=$2
    IDENTITY=$3
    ssh -N -i $IDENTITY -R $HOST:8080:localhost:80 $USER@$HOST
else
    echo "Benutzung: $0 nutzer zielserver private-key"
fi

