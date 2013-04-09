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

/*
	einstell read/write schnittstelle regleradresse input.csv [output.csv]
*/

#include <iostream>
#include <fstream>
#include <stdlib.h>
#include <string.h>

#include "einstell.h"

using std::string;
using std::ifstream;
using std::ofstream;
using std::iostream;
using std::fstream;

int main(int argc, const char* argv[]) {
	ifstream csv_in;
	ofstream csv_out;
	fstream tty;
}

Einstellwert::Einstellwert(string line, Einstelltabelle* p_parent) {
	parent = p_parent;
	set(line);
}

Einstellwert::Einstellwert(unsigned int p_id, signed int p_value, signed int p_min, signed int p_max, string p_text, Einstelltabelle* p_parent) {
	id = p_id;
	value = p_value;
	min = p_min;
	max = p_max;
	text = p_text;
	parent = p_parent;
}


void Einstellwert::read() {
	
}

void Einstellwert::write() {
	
}

//Parsen des Strings, damit die einzelnen Objekteigenschaften befüllt werden können.
void Einstellwert::set(string line) {
	
}

string Einstellwert::get() {
	
}

Einstelltabelle::Einstelltabelle(fstream* p_tty, ifstream* p_csv_in, ofstream* p_csv_out) {
	tty = p_tty;
	csv_in = p_csv_in;
	csv_out = p_csv_out;
	
	read_csv();
}

void Einstelltabelle::read() {
	
}

void Einstelltabelle::write() {
	
}

void Einstelltabelle::read_csv() {
	
}

void Einstelltabelle::write_csv() {
	
}

Exception::Exception(unsigned int p_type) {
	type = p_type;
}

void Exception::print() {
		
}
