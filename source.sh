#!/bin/sh
rm source.zip
rm docs/*
rm einstell/*
zip -r source *
chmod a+rw source.zip