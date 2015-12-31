#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX_BUF_LEN 2048
#define COPY_LEN    1024 

int main(int argc, char *argv[])
{
    char str_buf[MAX_BUF_LEN] = "Just test strncpy function.";
    char *p;
    
    printf("str init: %s\n", str_buf);

    if (argc > 1 && 0 != argv[1][0])
    {
        //snprintf(url, MAX_URL_LEN, "%s", argv[1]);
        p = strncpy(str_buf, argv[1], COPY_LEN);
    }

    printf("str_buf.length = %d v: %s\n", (int)strlen(str_buf), str_buf);
    printf("p: %s\n", p);

    return 0;
}
