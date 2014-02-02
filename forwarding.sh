#!/bin/sh

# Dieses Skript dient dem Weiterleiten des Webinterfaces per SSH-Forwarding zu einem anderen Computer

# Damit die Portweiterleitung funktioniert, müssen folgende Einstellungen gesetzt sein:
# SERVER (in /etc/ssh/sshd_config):
# PubkeyAuthentication yes
# PasswordAuthentication no #Achtung, hier kann man sich leicht selbst aussperren
#
# CLIENT also der Rechner mit Webinterface ( in ~/.ssh/config [für den User des Webservers] oder /etc/ssh/ssh_config):
# BatchMode yes
# ServerAliveInterval 10
# ServerAliveCountMax 3

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
    echo "Benutzung: $0 nutzer zielserver [private-key]"
fi

