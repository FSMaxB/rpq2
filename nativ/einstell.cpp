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

using std::cout;
using std::endl;	


//Variablen
ifstream csv_in;
ofstream csv_out;
fstream serial_interface;
unsigned int regleradresse;
bool mode;
const bool READ = false;
const bool WRITE = true;

void handle_args(int, const char**);

//testfunktionen etc
const unsigned char ansi_color = 27;
void test_einstellwert_set();
void test_einstellwert_get();


int main(int argc, const char* argv[]) {
	try {
		handle_args(argc, argv);
	} catch(Exception e) {
		e.print();
		return EXIT_FAILURE;
	}
	
	test_einstellwert_set();
	test_einstellwert_get();
	
	//TODO eigentlicher Programmablauf
	
	csv_in.close();
	csv_out.close();
	serial_interface.close();
	
	return EXIT_SUCCESS;
}

void handle_args(int argc, const char* argv[]) {
	if( (argc != 5) && (argc != 6) ) {
		throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
	}

	//Lesen oder Schreiben?
	if( !string("write").compare(argv[1]) ) {
		if( argc != 5 ) {
			throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
		}
		mode = WRITE;
	} else if( !string("read").compare(argv[1]) ) {
		if( argc != 6 ) {
			throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
		}
		mode = READ;
		csv_out.open(argv[5]);
		if( !csv_out.good() ) {
			throw Exception(Exception::BAD_FILE, string("Datei: ") + string(argv[5]));
		}
	} else {
		throw(Exception(Exception::BAD_PARAMS, string("Ungültiger Parameter: ") + string(argv[1])));
	}
	
	csv_in.open(argv[4]);
	if( !csv_in.good() ) {
		throw Exception(Exception::BAD_FILE, string("Datei: ") + string(argv[4]));
	}
	
	serial_interface.open(argv[2]);
	if( !serial_interface.good() ) {
		throw Exception(Exception::BAD_INTERFACE, string("Schnittstelle: ") + string(argv[2]));
	}
}

void test_einstellwert_set() {
	cout << ansi_color << "[31mTeste Einstellwert::set(string) ..." << ansi_color << "[0m" << endl;
	Einstellwert test("1,100,0,200,Dies ist eine Beschreibung!",NULL);
	cout << "id: " << test.id << endl;
	cout << "value: " << test.value << endl;
	cout << "min: " << test.min << endl;
	cout << "max: " << test.max << endl;
	cout << "text: " << test.text << endl;
}

void test_einstellwert_get() {
	cout << ansi_color << "[31mTeste Einstellwert::get() ..." << ansi_color << "[0m" << endl;
	Einstellwert test(1,100,-20,200,string("Mal sehen ob das klappt!"),NULL);
	cout << test.get() << endl;
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
	//TODO
}

void Einstellwert::write() {
	//TODO
}

//Parsen des Strings, damit die einzelnen Objekteigenschaften befüllt werden können.
void Einstellwert::set(string line) {
	char temp[256];
	sscanf(line.c_str(), "%i,%i,%i,%i,%[^,]s", &id, &value, &min, &max, temp);

	text = temp;
}

//Gibt eine CSV-Zeile mit den Objekteigenschaften zurück
string Einstellwert::get() {
	char temp[256];
	sprintf( temp, "%i,%i,%i,%i,%s", id, value, min, max, text.c_str() );
	return string(temp);
}

Einstelltabelle::Einstelltabelle(fstream* p_tty, ifstream* p_csv_in, ofstream* p_csv_out) {
	tty = p_tty;
	csv_in = p_csv_in;
	csv_out = p_csv_out;
	
	read_csv();
}

//Lesen der Einstellwerten aus Regler
void Einstelltabelle::read() {
	//TODO
}

//Schreiben der Einstellwerte in Regler
void Einstelltabelle::write() {
	//TODO
}

//Einlesen der Einstellwerte aus CSV
void Einstelltabelle::read_csv() {
	//TODO
}

//Schreiben der Einstellwerte in CSV
void Einstelltabelle::write_csv() {
	
}

Exception::Exception(unsigned int p_type, string p_message) {
		type = p_type;
		message = p_message;
}

Exception::Exception(unsigned int p_type) {
	type = p_type;
	message = "";
}

//Gibt die Exception auf der Konsole aus
void Exception::print() {
		//Ausgabe nach Fehlertyp
		switch(type) {
			case BAD_PARAMS:
				cout << "FEHLER: Ungültige Parameter" << endl;
				break;
			case BAD_FILE:
				cout << "FEHLER: Ungültige Datei" << endl;
				break;
			case BAD_INTERFACE:
				cout << "FEHLER: Ungültige Schnittstelle" << endl;
				break;
		}
		
		if(message != "") {
				cout << message << endl;
		}
}
