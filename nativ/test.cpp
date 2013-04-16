#include <iostream>
#include <stdlib.h>

using std::cout;
using std::endl;

int main(int argc, char** argv) {
	for(int i = 0; i < argc; i++) {
		cout << i << ": " << argv[i] << endl;
	}
	
	return EXIT_SUCCESS;
}
