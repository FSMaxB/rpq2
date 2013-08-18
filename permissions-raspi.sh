#!/bin/sh
USER=pi
GROUP=pi
chown -R $USER:$GROUP .
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 777 docs einstell-mess log misc pdo wartung
chmod 666 docs/* einstell-mess/* log/* misc/* pdo/* wartung/* settings.cfg
chmod a+x root.sh nativ/compile.sh nativ/einstell nativ/mess nativ/shutdown-timer nativ/test
chown -R root:root update
chmod +s update/root
chmod o+x update/root
