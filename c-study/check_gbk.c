#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define STR_BUFF_SIZE 2048

#define GBK_NUM     0x5e02  //24066
#define GBK_1LO     0x81    //129
#define GBK_1HI     0xfe    //254
#define GBK_1NUM    0x7e    //126
#define GBK_2LO     0x40    //64
#define GBK_2HI     0xfe    //254
#define GBK_2NUM    0xbf    //191
#define GBK_2INV    0x7f    //127

int is_gbk( u_char *pstr )
{
    if ( (pstr[0] >= GBK_1LO) && (pstr[0] <= GBK_1HI) &&
         (pstr[1] >= GBK_2LO) && (pstr[1] <= GBK_2HI) &&
             (pstr[1] != GBK_2INV)
       )
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

int main(int argc, char *argv[])
{
    unsigned char str_buff[STR_BUFF_SIZE] = "abcdefghijklmnopqrstuvwxyz1234567890\
`~!@#$%^&*()-_=+ABCDEFGHIJKLMNOPQRSTUVWXYZ;,./|{}[]'\"\\";
    unsigned char *p = str_buff;
    
    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(p, STR_BUFF_SIZE, "%s", argv[1]);
    }

    while (*p)
    {
        unsigned char gbk_str[STR_BUFF_SIZE] = {0};
        if (is_gbk(p))
        {
            snprintf(gbk_str, 3, "%s", p);
            printf("This string HAS gbk char: [%s]\n", gbk_str);
            /** Find GBK char, would move point. */
            p++;
        }
        else
        {
            snprintf(gbk_str, p - str_buff + 1, "%s", str_buff);
            printf("### Can NOT find gbk char at present: %s\n", gbk_str);
        }

        p++;
    }
    
    return 0;
}

