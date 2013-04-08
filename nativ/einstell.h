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
#ifndef EINSTELL_H
#define EINSTELL_H

#include <string.h>

class Einstellwert {
public:
	Einstellwert(unsigned int, signed int, signed int, signed int, string);
	
	unsigned int id();
	signed int value();
	signed int min();
	signed int max();
	string text();
	
	void setId(unsigned int);
	void setValue(signed int);
	void setMin(signed int);
	void setMax(signed int);
	void setText(string);
private:
	unsigned int id;
	signed int value, min, max;
	string text;
};
#endif
