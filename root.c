#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#inlucde <unistd.h>

int main() {
    setuid(0);
    system("sh permissions-raspi.sh");
    
    return 0;
}
