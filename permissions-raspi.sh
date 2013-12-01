#!/bin/sh
USER=pi
GROUP=pi
chown -R $USER:$GROUP .
find . -type f -exec chmod 644 {} \;    #Alle Dateien für den Besitzer rw- und für alle anderen r-- machen
find . -type d -exec chmod 755 {} \;    #Alle Ordner für den Besitzer rwx und für alle anderen r-x machen
chmod 777 docs einstell-mess log misc pdo wartung   #Ordner fürs Webinterface beschreibbar machen
chmod 666 docs/* einstell-mess/* log/* misc/* pdo/* wartung/* settings.cfg  #Dateien fürs Webinterface beschreibbar machen
chmod a+x root.sh nativ/compile.sh nativ/einstell nativ/mess nativ/shutdown-timer nativ/test    #Alle Skripte und C/C++-Programm ausführbar machen
chown -R root:root update   #Dem root-Wrapper von root besitzen lassen
chmod +s update/root    #Setuid-Bit des root-Wrappers setzen
chmod a+x update/root   #root-Wrapper ausführbar machen
