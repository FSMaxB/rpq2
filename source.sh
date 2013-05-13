#!/bin/sh
rm source.zip
rm owndocs/*
rm einstell/*
zip -r source *
chmod a+rw source.zip