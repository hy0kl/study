#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int main(int argc, char *argv[])
{
    unsigned char str_buff[2048] = "abcdefghijklmnopqrstuvwxyz1234567890`~!@#$%^&*()-_=+ABCDEFGHIJKLMNOPQRSTUVWXYZ;,./|{}[]'\"\\";
    unsigned char *p = str_buff;

    int str_len = (int)strlen(str_buff);
    
    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(p, str_len, "%s", argv[1]);
    }

    while (*p)
    {
        if (isascii(*p))
        {
            printf("This char is ASCII: [%c]\n", *p);
        }
        else
        {
            printf("### This char is NOT ASCII: [[%c]]", *p);
        }

        p++;
    }
    
    return 0;
}
