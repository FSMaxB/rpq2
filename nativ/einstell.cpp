/*
    RPQ2-Webinterface
    
    Copyright (C) 2012 Innowatt Energiesysteme GmbH
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
	einstell read/write regleradresse input.csv [output.csv]
*/

#include <iostream>
#include <fstream>
#include <stdlib.h>

#include "einstell.h"

int main(int argc, const char* argv[]) {
	ifstream csv;
	
	
	
}

Einstellwert::Einstellwert(unsigned int p_id, signed int p_value, signed int p_min, signed int p_max, string p_text) {
	id = p_id;
	value = p_value;
	min = p_min;
	max = p_max;
	text = p_text;
	
}

unsigned int Einstellwert::id() {
	return id;
}

signed int Einstellwert::value() {
	return value;
}

signed int Einstellwert::min() {
	return min;
}

signed int Einstellwert::max() {
	return max;
}

string Einstellwert::text() {
	return text;
}

void Einstellwert::setId(unsigned int p_id) {
	id = p_id;
}

void Einstellwert::setValue(signed int p_value) {
	value = p_value;
}

void Einstellwert::setMin(signed int p_min) {
	min = p_min;
}

void Einstellwert::setMax(signed int p_max) {
	max = p_max;
}

void Einstellwert::setText(string p_text) {
	text = p_text;
}
