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
	einstell wartung schnittstelle sdo
*/

#include <iostream>
#include <fstream>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <algorithm>
#include <sstream>
#include <pthread.h>
#include <cctype>
#include <time.h>

#include "einstell.h"

using std::string;
using std::ifstream;
using std::ofstream;
using std::iostream;
using std::fstream;
using std::stringstream;
using std::swap;
using std::transform;

using std::cout;
using std::endl;	

//Konstanten
const unsigned int DELAY = 5;	//Delay zwischen Werten in Milisekunden
const unsigned int BLOCK_DELAY = 10;	//Delay zwischen zwei Blöcken in Milisekunden
const unsigned int TIMEOUT = 1;	//Timeout beim Warten auf Antwort von Regler in Sekunden
const bool READ = false;
const bool WRITE = true;
const bool SIGNED = true;
const bool UNSIGNED = false;
const bool READY = true;
const bool BUSY = false;
const unsigned int BUFFER = 256;

//Variablen
ifstream g_csv_in;
ofstream g_csv_out;
ifstream tty_in;
ofstream tty_out;
unsigned int g_regleradresse;
bool mode;
bool status;
bool testmode = false;		//Testmodus zu Debug-Zwecken
bool b_wartung = false;

struct thread_p {
	string* s;
	bool fail;
};

static thread_p params;

signed long hex_to_int(string, bool);
string int_to_hex(signed long, unsigned int);
void handle_args(int, const char**);
void wartung(string);
void send(string);
void *receive(void*);

//testfunktionen etc
const unsigned char ansi_color = 27;
void test_einstellwert_set();
void test_einstellwert_get();
void test_einstelltabelle_csv();
void test_sdo_out();
void test_sdo_in();

signed long hex_to_int(string hex, bool mode = UNSIGNED) {
	signed long unsigned_value;
	stringstream ss;
	ss << std::hex << hex;
	ss >> unsigned_value;
	signed long pot = pow(16,hex.length());
	if( (mode == SIGNED) && (unsigned_value > ( ( pot / 2 ) - 1 ) ) ) {
		return (unsigned_value - pot);
	}
	return unsigned_value;
}

string int_to_hex(signed long value, unsigned int length) {
	string result;
	stringstream ss;

	ss << std::hex << value;
	ss >> result;

	//String kürzen
	if( result.length() > length ) {
		result.erase(0,result.length()-length);
	} else if( result.length() < length ) {
		result.insert(0, length - result.length(), '0');
	}

	transform(result.begin(), result.end(),result.begin(), ::toupper);

	return result;
}

string get(ifstream* input, char delimiter = '\n') {
	signed char buffer;
	string result;
	while( (buffer = input->get()) != (EOF) ) {
		//buffer = input->get();
		if(buffer == delimiter) {
			break;
		}
		if(input->bad()) {
			throw Exception(Exception::IO_ERROR);
		}
		result += buffer;
	}
	return result;
}

int main(int argc, const char* argv[]) {
	try {
		handle_args(argc, argv);
	} catch(Exception e) {
		e.print();
		return EXIT_FAILURE;
	}

	//test_einstellwert_set();
	//test_einstellwert_get();
	//test_einstelltabelle_csv();
	//test_sdo_out();
	//test_sdo_in();
	
	Einstelltabelle tabelle(&g_csv_in, &g_csv_out);
	if(mode == READ) {
		tabelle.read(g_regleradresse);
	} else {
		tabelle.write(g_regleradresse);
	}
	
	g_csv_in.close();
	g_csv_out.close();
	tty_in.close();
	tty_out.close();
	
	return EXIT_SUCCESS;
}

void handle_args(int argc, const char* argv[]) {
	//Hilfe ausgeben
	if( (argc == 2) && !(string(argv[1]).compare("--help")) ) {
		cout << "Programm zum auslesen und einspeichern von Einstellwerten in den RPQ2-Regler von Innowatt Energiesysteme GmbH" << endl;
		cout << endl;
		cout << "Verwendung:" << endl;
		cout << "einstell write/read  schnittstelle regleradresse input.csv [output.csv]" << endl;
		cout << "einstell wartung schnittstelle sdo" << endl;
		cout << endl;
		cout << "write: einspeichern der Einstellwerte in \"input.csv\" über \"schnittstelle\" in Regler unter \"regleradresse\"" << endl;
		cout << "read: auslesen der Einstellwerte in \"input.csv\" über \"schnittstelle\" aus Regler unter \"regleradresse\" und speichern der Ergebnisse in \"output.csv\"" << endl;
		exit(EXIT_SUCCESS);
	}

	if( (argc != 4) && (argc != 5) && (argc != 6) ) {
		throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
	}

	//Lesen, Schreiben oder Wartung?
	if( !string("wartung").compare(argv[1]) ) {
		//Schnittstelle
		tty_in.open(argv[2]);
		tty_out.open(argv[2]);
		if( (!tty_in.good()) || (!tty_out.good()) ) {
			throw Exception(Exception::BAD_INTERFACE, string("Schnittstelle: ") + string(argv[2]));
		}
		
		wartung(string(argv[3]));
		
		tty_in.close();
		tty_out.close();
		exit(EXIT_SUCCESS);
		
	} else if( !string("write").compare(argv[1]) ) {
		if( argc != 5 ) {
			throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
		}
		mode = WRITE;
	} else if( !string("read").compare(argv[1]) ) {
		if( argc != 6 ) {
			throw Exception(Exception::BAD_PARAMS, "Falsche Anzahl an Parametern!");
		}
		mode = READ;
		g_csv_out.open(argv[5]);
		if( !g_csv_out.good() ) {
			throw Exception(Exception::BAD_FILE, string("Datei: ") + string(argv[5]));
		}
	} else {
		throw(Exception(Exception::BAD_PARAMS, string("Ungültiger Parameter: ") + string(argv[1])));
	}
	
	g_csv_in.open(argv[4]);
	if( !g_csv_in.good() ) {
		throw Exception(Exception::BAD_FILE, string("Datei: ") + string(argv[4]));
	}
	
	tty_in.open(argv[2]);
	tty_out.open(argv[2]);
	if( (!tty_in.good()) || (!tty_out.good()) ) {
		throw Exception(Exception::BAD_INTERFACE, string("Schnittstelle: ") + string(argv[2]));
	}
	
	sscanf(argv[3], "%u", &g_regleradresse);
}

void wartung(string sdo) {
	b_wartung = true;
	
	//Übergabeparameter für nanosleep
	struct timespec timeout_step;
	timeout_step.tv_sec = 0;
	timeout_step.tv_nsec = 100 * 1000000;	//100 Milisekunden
	//Übergabeparameter für nanosleep
	struct timespec delay;
	delay.tv_sec = (int) DELAY / 1000;			//Sekunden aus DELAY
	delay.tv_nsec = (DELAY % 1000) * 1000000;	//Milisekunden aus DELAY
	struct timespec block_delay;
	block_delay.tv_sec = (int) BLOCK_DELAY / 1000;
	delay.tv_nsec = (BLOCK_DELAY % 1000) * 1000000;	//Milisekunden aus DELAY
	
	string received;
	params.s = &received;
	params.fail = false;
	pthread_t thread;
	unsigned int i;

	received.clear();
	send(sdo);
	
	pthread_create(&thread, NULL, receive, (void*) &params);
	pthread_detach(thread);
	
	for(unsigned int j = 0; j <= (10*TIMEOUT); j++) {
			nanosleep(&timeout_step, NULL);
	}
	
	pthread_cancel(thread);
}

void test_einstellwert_set() {
	cout << ansi_color << "[31mTeste Einstellwert::set(string) ..." << ansi_color << "[0m" << endl;
	Einstellwert test("1,100,0,200,Dies ist eine Beschreibung!");
	cout << "id: " << test.id << endl;
	cout << "value: " << test.value << endl;
	cout << "min: " << test.min << endl;
	cout << "max: " << test.max << endl;
	cout << "text: " << test.text << endl;
}

void test_einstellwert_get() {
	cout << ansi_color << "[31mTeste Einstellwert::get() ..." << ansi_color << "[0m" << endl;
	Einstellwert test(1,100,-20,200,string("Mal sehen ob das klappt!"));
	cout << test.get() << endl;
}

void test_einstelltabelle_csv() {
	cout << ansi_color << "[31mTeste Einstelltabelle::read/write_csv ..." << ansi_color << "[0m" << endl;
	Einstelltabelle test(&g_csv_in, &g_csv_out);
	try {
		test.test_csv();
	} catch (Exception e) {
		e.print();
	}
}

void test_sdo_out() {
	cout << ansi_color << "[31mTeste SDO::get() ..." << ansi_color << "[0m" << endl;

	//Schreiben
	SDO test(1536, 2, 43, 8212, 11, 99);
	cout << test.get_string() << endl;

	//Lesen
	test.set(1536, 2, 64, 8212, 11, 99);
	cout << test.get_string() << endl;
}

void test_sdo_in() {
	cout << ansi_color << "[31mTeste SDO::set(string,unsigned int) ..." << ansi_color << "[0m" << endl;
	SDO test(string("0582601420050200008000"), 2);
	cout << "identifier: " << test.identifier << endl;
	cout << "regleradresse: " << test.regleradresse << endl;
	cout << "control: " << test.control << endl;
	cout << "index: " << test.index << endl;
	cout << "subindex: " << test.subindex << endl;
	cout << "value: " <<  test.value << endl;
}

Einstellwert::Einstellwert(string line) {
	set(line);
}

Einstellwert::Einstellwert(unsigned int p_id, signed int p_value, signed int p_min, signed int p_max, string p_text) {
	id = p_id;
	value = p_value;
	min = p_min;
	max = p_max;
	text = p_text;
}


void Einstellwert::read(unsigned int regleradresse, unsigned int index) {
	//Übergabeparameter für nanosleep
	struct timespec timeout_step;
	timeout_step.tv_sec = 0;
	timeout_step.tv_nsec = 100 * 1000000;	//100 Milisekunden
	//Übergabeparameter für nanosleep
	struct timespec delay;
	delay.tv_sec = (int) DELAY / 1000;			//Sekunden aus DELAY
	delay.tv_nsec = (DELAY % 1000) * 1000000;	//Milisekunden aus DELAY
	struct timespec block_delay;
	block_delay.tv_sec = (int) BLOCK_DELAY / 1000;
	delay.tv_nsec = (BLOCK_DELAY % 1000) * 1000000;	//Milisekunden aus DELAY

	SDO package_sent( 0x600, regleradresse, 0x40, index, (*this));
	package_sent.value = 0;
	SDO package_received(0,0,0,0,0,0);
	string received;
	params.s = &received;
	params.fail = false;
	pthread_t thread;
	unsigned int i;

	for(i = 0; i < 3; i++) {
		received.clear();
		send(package_sent.get_string());
		
		if(testmode) {
			send(string("\n"));
		}

		status = BUSY;
		pthread_create(&thread, NULL, receive, (void*) &params);
		pthread_detach(thread);

		for(unsigned int j = 0; j <= (10*TIMEOUT); j++) {
			nanosleep(&timeout_step, NULL);
			if( status == READY ) {
				break;
			}
		}

		pthread_cancel(thread);

		//Überprüfen der Antwort
		if( received.length() == 23 ) {	//Wenn die Falsche Zahl an Zeichen zurückgekommen ist, braucht man gar nicht erst zu testen
			package_received.set(received.substr(3,received.length() - 3), hex_to_int(received.substr(1,2)));
			if( 	(package_received.regleradresse == regleradresse)
				&&	(package_received.identifier == 0x580)
				&&	(package_received.control == 0x4B)
				&&	(package_received.index == index)
				&&	(package_received.subindex == id)) {

				i = 4;
			}
		}

		send(string("csdo"));	//Clearen des Reglers
		
		if(testmode) {
			send(string("\n"));
		}
		
		nanosleep(&block_delay, NULL);

	}

	if( i == 3 ) {	//Wurde die Schleife dreimal ohne Ergebnis durchlaufen?
		throw Exception(Exception::NO_RESPONSE, string("Fehler bei ") + get() + string("\nAntwort:") + received);
	} else {
		value = package_received.value;
	}
}

void Einstellwert::write(unsigned int regleradresse, unsigned int index) {
	//Übergabeparameter für nanosleep
	struct timespec timeout_step;
	timeout_step.tv_sec = 0;
	timeout_step.tv_nsec = 100 * 1000000;	//100 Milisekunden
	//Übergabeparameter für nanosleep
	struct timespec delay;
	delay.tv_sec = (int) DELAY / 1000;			//Sekunden aus DELAY
	delay.tv_nsec = (DELAY % 1000) * 1000000;	//Milisekunden aus DELAY
	struct timespec block_delay;
	block_delay.tv_sec = (int) BLOCK_DELAY / 1000;
	delay.tv_nsec = (BLOCK_DELAY % 1000) * 1000000;	//Milisekunden aus DELAY

	SDO package_sent( 0x600, regleradresse, 0x2B, index, (*this));
	SDO package_received(0,0,0,0,0,0);
	string received;
	params.s = &received;
	params.fail = false;
	pthread_t thread;
	unsigned int i;
	
	for(i = 0; i < 3; i++) {
		received.clear();
		send(package_sent.get_string());
		
		if(testmode) {
			send(string("\n"));
		}

		status = BUSY;
		pthread_create(&thread, NULL, receive, (void*) &params);
		pthread_detach(thread);

		for(unsigned int j = 0; j <= (10*TIMEOUT); j++) {
			nanosleep(&timeout_step, NULL);
			if( status == READY) {
				break;
			}
		}

		pthread_cancel(thread);

		//Überprüfen der Antwort
		if( received.length() == 23 ) {	//Wenn die Falsche Zahl an Zeichen zurückgekommen ist, braucht man gar nicht erst zu testen
			package_received.set(received.substr(3,received.length() - 3), hex_to_int(received.substr(1,2)));
			if( 	(package_received.regleradresse == regleradresse)
				&&	(package_received.identifier == 0x580)
				&&	(package_received.control == 0x60)
				&&	(package_received.index == index)
				&&	(package_received.subindex == id)) {
				i = 4;
			}
		}

		send(string("csdo"));	//Clearen des Reglers
		
		if(testmode) {
			send(string("\n"));
		}

		nanosleep(&block_delay, NULL);

	}

	if( i == 3 ) {	//Wurde die Schleife dreimal ohne Ergebnis durchlaufen?
		throw Exception(Exception::NO_RESPONSE, string("Fehler bei ") + get() + string("\nAntwort:") + received);
	}
}

void send(string s) {
	//Übergabeparameter für nanosleep
	struct timespec delay;
	delay.tv_sec = (int) DELAY / 1000;			//Sekunden aus DELAY
	delay.tv_nsec = (DELAY % 1000) * 1000000;	//Milisekunden aus DELAY

	bool send_delay = true;	//Immer wenn auf true soll ein DELAY gewartet werden
	for(unsigned int i = 0; i < s.length(); i++) {
		tty_out << s[i];
		tty_out.flush();
		send_delay++;
		if(send_delay) {	//Alle zwei Zeichen wird DELAY gewartet
			nanosleep(&delay, NULL);
		}
		if( tty_out.fail() ) {
			throw Exception(Exception::IO_ERROR, "Konnte nicht auf Schnittstelle schreiben.");
		}
	}
}

void *receive(void* parameter) {
	signed char buffer;
	if(b_wartung) {
		while(true) {
			tty_in >> buffer;
			*(params.s) += buffer;
		}
	} else {
		for(unsigned int i = 0; i < 23; ) {
				tty_in >> buffer;
				if( isalnum(buffer) ) {
					*(params.s) += buffer;
					i++;
				}
		}
	}
	status = READY;
}

//Parsen des Strings, damit die einzelnen Objekteigenschaften befüllt werden können.
void Einstellwert::set(string line) {
	char temp[BUFFER];
	if( line.length() > (BUFFER - 1) ) {
		throw Exception(Exception::BUFFER_OVERFLOW);
	}
	sscanf(line.c_str(), "%i,%i,%i,%i,%[^,]s", &id, &value, &min, &max, temp);
	
	//Überprüfen ob Wert in gültigem bereich, sonst korrigieren.
	if( value > max ) {
		value = max;
	} else if( value < min )  {
		value = min;
	}
	text = temp;
}

//Gibt eine CSV-Zeile mit den Objekteigenschaften zurück
string Einstellwert::get() {
	char temp[BUFFER];
	sprintf( temp, "%i,%i,%i,%i,%s", id, value, min, max, text.c_str() );
	return string(temp);
}

Einstelltabelle::Einstelltabelle(ifstream* p_csv_in, ofstream* p_csv_out) {
	csv_in = p_csv_in;
	csv_out = p_csv_out;
	
	read_csv();
}

//Lesen der Einstellwerte aus Regler
void Einstelltabelle::read(unsigned int regleradresse) {
	list<Einstellwert>::iterator i = storage.begin(), end = storage.end();
	for (; i != end; ++i) {
		try {
			i->read(regleradresse, id);
		} catch(Exception e) {
			e.print();
			exit(EXIT_FAILURE);
		}
	}

	write_csv();
}

//Schreiben der Einstellwerte in Regler
void Einstelltabelle::write(unsigned int regleradresse) {
	list<Einstellwert>::iterator i = storage.begin(), end = storage.end();
	for (; i != end; ++i) {
		try {
			i->write(regleradresse, id);
		} catch (Exception e) {
			e.print();
			exit(EXIT_FAILURE);
		}

	}
}

//Einlesen der Einstellwerte aus CSV
void Einstelltabelle::read_csv() {
	string buffer;
	
	//Kommentar
	comment = get(csv_in);
	
	//Hole "Index," aus dem Stream
	get(csv_in, ',');
	
	//Lese Index aus
	id = hex_to_int(get(csv_in));
	
	//Restliche Zeilen einlesen
	while( !csv_in->eof() ) {	//solange Dateiende noch nicht erreicht
		try {
		buffer = get(csv_in);
		} catch (Exception e) {
			e.message = "Konnte CSV nicht einlesen.";
			e.print();
			exit(EXIT_FAILURE);
		}
		if( !buffer.empty() ) {
			if( buffer[0] != '*' ) {	//Trennzeilen werden nicht eingelesen
				storage.push_back( Einstellwert( buffer) );
			}
		}
		buffer.clear();
	}
}

void Einstelltabelle::test_csv() {
		write_csv();
}

//Schreiben der Einstellwerte in CSV
void Einstelltabelle::write_csv() {
	(*csv_out) << comment << endl;
	(*csv_out) << "Index," << int_to_hex(id, 4) << endl;
	
	list<Einstellwert>::iterator i = storage.begin(), end = storage.end();
	for (; i != end; ++i) {
		(*csv_out) << i->get() << endl;
	}
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
			case BUFFER_OVERFLOW:
				cout << "FEHLER: Pufferüberlauf" << endl;
				break;
			case IO_ERROR:
				cout << "FEHLER: Ein-/Ausgabefehler" << endl;
				break;
			case NO_RESPONSE:
				cout << "FEHLER: Regler antwortet nicht korrekt" << endl;
				break;
			case BAD_SDO:
				cout << "FEHLER: Inkorrekte Antwort des Reglers" << endl;
				break;
		}
		
		if(message != "") {
				cout << message << endl;
		}
}

SDO::SDO(string sdo, unsigned int p_regleradresse) {
	set(sdo, p_regleradresse);
}

SDO::SDO(unsigned int p_identifier, unsigned int p_regleradresse, unsigned int p_control, unsigned int p_index, Einstellwert p_einstellwert) {
	set(p_identifier, p_regleradresse, p_control, p_index, p_einstellwert);
}

SDO::SDO(unsigned int p_identifier, unsigned int p_regleradresse, unsigned int p_control, unsigned int p_index, unsigned int p_subindex, signed int p_value) {
	set(p_identifier, p_regleradresse, p_control, p_index, p_subindex, p_value);
}

void SDO::set(unsigned int p_identifier, unsigned int p_regleradresse, unsigned int p_control, unsigned int p_index, unsigned int p_subindex, signed int p_value) {
	identifier = p_identifier;
	regleradresse = p_regleradresse;
	control = p_control;
	index = p_index;
	subindex = p_subindex;
	value = p_value;
}

string SDO::get_string() {
	//SDO-Identifier
	string sdo_identifier = int_to_hex(identifier + regleradresse, 4);

	//CONTROL
	string s_control = int_to_hex(control,2);

	//Index
	string s_index = int_to_hex(index, 4);
	swap(s_index[0], s_index[2]);
	swap(s_index[1], s_index[3]);

	//Subindex
	string s_subindex = int_to_hex(subindex,2);

	//Wert
	string s_value = int_to_hex(value, 4);
	swap(s_value[0], s_value[2]);
	swap(s_value[1], s_value[3]);
	s_value += "0000";

	return sdo_identifier + s_control + s_index + s_subindex + s_value + string("8000");
}

void SDO::set(string sdo, unsigned int p_regleradresse) {
	regleradresse = p_regleradresse;
	identifier = hex_to_int(sdo.substr(0,4))  - regleradresse;
	control = hex_to_int(sdo.substr(4,2));
	index = hex_to_int( sdo.substr(8,2) + sdo.substr(6,2));
	subindex = hex_to_int( sdo.substr(10,2));
	value = hex_to_int( sdo.substr(14,2) + sdo.substr(12,2), SIGNED);
}

void SDO::set(unsigned int p_identifier, unsigned int p_regleradresse, unsigned int p_control, unsigned int p_index, Einstellwert p_einstellwert) {
	identifier = p_identifier;
	regleradresse = p_regleradresse;
	control = p_control;
	index = p_index;
	subindex = p_einstellwert.id;
	value = p_einstellwert.value;
}
