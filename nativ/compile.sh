#!/bin/sh
fpc -Mdelphi CSV_ASM > /dev/null;
rm CSV_ASM.o;
echo CSV_ASM kompiliert;
gcc send.c -o send -lpthread;
echo send kompiliert;
gcc receive.c -o receive -lpthread;
echo receive kompiliert;
