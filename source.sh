#!/bin/sh
rm source.zip;
rm owndocs/*;
rm regler/*;
rm csv/*;
rm einstell/*;
rm tty-logs/*;
rm tmp/*;
zip -r source *;
chmod +rw source.zip;
