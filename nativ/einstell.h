/*
    RPQ2-Webinterface

    Copyright (C) 2012-2013 Innowatt Energiesysteme GmbH
    Author: Max Bruckner

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
*/
#ifndef EINSTELL_H
#define EINSTELL_H

#include <string.h>
#include <fstream>
#include <list>

using std::string;
using std::fstream;
using std::ifstream;
using std::ofstream;
using std::list;

class Einstelltabelle;
class SDO;

class Einstellwert {
public:
    Einstellwert(string);
    Einstellwert(unsigned int, signed int, double, signed int, string);
    unsigned int id;
    signed int value, max;
    double min;
    string text;
    void read(unsigned int, unsigned int);
    void write(unsigned int, unsigned int);
    void set(string);
    string get();
};

class Einstelltabelle {
public:
    Einstelltabelle(ifstream*, ofstream*);

    string comment;
    unsigned int id;
    list<Einstellwert> storage;

    void read(unsigned int);
    void write(unsigned int);

    void test_csv();
private:
    ifstream* csv_in;
    ofstream* csv_out;
    void read_csv();
    void write_csv();
};

class Exception {
public:
    Exception(unsigned int);
    Exception(unsigned int, string);
    unsigned int type;
    string message;
    void print();

    static const unsigned int BAD_PARAMS = 0;
    static const unsigned int BAD_FILE = 1;
    static const unsigned int BAD_INTERFACE = 2;
    static const unsigned int BUFFER_OVERFLOW = 3;
    static const unsigned int IO_ERROR = 4;
    static const unsigned int NO_RESPONSE = 5;
    static const unsigned int BAD_SDO = 6;
};

class SDO {
public:
    SDO(string, unsigned int);
    SDO(unsigned int, unsigned int, unsigned int, unsigned int, Einstellwert);
    SDO(unsigned int, unsigned int, unsigned int, unsigned int, unsigned int, signed int);

    string get_string();
    void set(string, unsigned int);
    void set(unsigned int, unsigned int, unsigned int, unsigned int, Einstellwert);
    void set(unsigned int, unsigned int, unsigned int, unsigned int, unsigned int, signed int);

    unsigned int identifier;
    unsigned int regleradresse;
    unsigned int control;
    unsigned int index;
    unsigned int subindex;
    signed int value;
};
#endif
