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

class Einstellwert {
public:
	Einstellwert(string, Einstelltabelle*);
	Einstellwert(unsigned int, signed int, signed int, signed int, string, Einstelltabelle*);
	unsigned int id;
	signed int value, min, max;
	string text;
	void read();
	void write();
	void set(string);
	string get();
private:
	Einstelltabelle* parent;
};

class Einstelltabelle {
public:
	Einstelltabelle(fstream*, ifstream*, ofstream*);
	fstream* tty;
	
	string comment;
	unsigned int id;
	
	void read();
	void write();
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
};
#endif
