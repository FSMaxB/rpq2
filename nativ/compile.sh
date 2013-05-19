#!/bin/sh
g++ einstell.cpp -o einstell -lpthread -lm
echo einstell kompiliert
g++ test.cpp -o test
echo test kompiliert
g++ mess.cpp -o mess -lm -lpthread
echo mess kompiliert
