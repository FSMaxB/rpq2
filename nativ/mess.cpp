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

#include <iostream>
#include <fstream>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <algorithm>
#include <sstream>
#include <pthread.h>
#include <time.h>

using std::string;
using std::ifstream;
using std::ofstream;
using std::cout;
using std::endl;
using std::stringstream;

const unsigned int TIMEOUT = 200;        //Timeout in ms
const bool SIGNED = true;
const bool UNSIGNED = false;
const bool READY = true;
const bool BUSY = false;

struct thread_p {
    string received;
    bool status;
    ifstream* tty;
};

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

string int_to_bin(unsigned int value, unsigned int bits) {
    string result;
    for(signed int i = bits - 1; i >= 0; i--) {
        if( ((unsigned int) pow(2,i)) & value) {
            result += "1";
        } else {
            result += "0";
        }
    }
    return result;
}

void *receive(void* parameter) {
    thread_p* params = (thread_p*) parameter;
    signed char buffer;
    for(unsigned int i = 0; i < 67; ) {
        *(params->tty) >> buffer;
        if( isalnum(buffer) ) {
            params->received += buffer;
            i++;
         }
    }
    params->status = READY;
}

void send(string s, ofstream* tty_out) {
    for(unsigned int i = 0; i < s.length(); i++) {
        (*tty_out) << s[i];
        tty_out->flush();
    }
}

int main(int argc, char** argv) {
    //Übergabeparameter für nanosleep
    struct timespec timeout_step;
    timeout_step.tv_sec = 0;
    timeout_step.tv_nsec = 1000000;   //1ms

    ifstream tty_in(argv[1]);
    ofstream tty_out(argv[1]);

    unsigned int regleradresse;
    sscanf(argv[2], "%i", &regleradresse);

    thread_p thread_data;
    thread_data.tty = &tty_in;
    thread_data.status = BUSY;

    send(string("mw") + int_to_hex(regleradresse, 2), &tty_out);

    pthread_t thread;
    pthread_create(&thread, NULL, receive, (void*) &thread_data);
    pthread_detach(thread);

    for(unsigned int i = 0; i <= TIMEOUT; i++) {
            nanosleep(&timeout_step, NULL);
            if(thread_data.status == true)
                break;
    }
    pthread_cancel(thread);

    for(unsigned int i = 0; (3 + 4*i) < thread_data.received.size(); i++) {
        string hex = thread_data.received.substr(3 + i*4, 4);
        signed int wert = hex_to_int(hex, SIGNED);
        cout << wert << "," << hex << "," << int_to_bin( wert, 16) << endl;
    }
}
