#include <cstdlib>
#include <fstream>
#include <ctime>
#include <sstream>
#include <iostream>
#include <string>

using std::string;
using std::ifstream;
using std::ofstream;
using std::stringstream;
using std::cout;
using std::endl;
using std::ios_base;

int main(int argc, char** argv) {
	//Beim Starten aktuelle Zeit in Datei schreiben
	ofstream output("/var/www/misc/timestamp");
	output << (unsigned long int) time(NULL);
	output.close();
	
	unsigned long int current_time;
	unsigned long int timestamp;
	unsigned long int timeout;
	ifstream timestamp_in;
	ifstream timeout_in;
	stringstream converter;
	string s_temp;
	do {
		current_time = time(NULL);
		
		timestamp_in.open("/var/www/misc/timestamp");
		getline(timestamp_in, s_temp);
		converter << s_temp;
		converter >> timestamp;
		converter.clear();
		timestamp_in.close();
		
		sleep(10);
		
		timeout_in.open("/var/www/misc/shutdown_time");
		getline(timeout_in, s_temp);
		converter << s_temp;
		converter >> timeout;
		timeout *= 60;
		if( (timeout != 0) &&(timeout < 300))
			timeout = 300;
		converter.clear();
		timeout_in.close();
	} while( (timeout == 0) || ((current_time - timestamp) < timeout) );
	
	system("shutdown -h now");
	
	return EXIT_SUCCESS;
}
