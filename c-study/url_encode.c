#include <stdio.h>
#include <malloc.h>
#include <string.h>
#include <stdlib.h>

#define MAX_URL_LEN 2048
 
char from_hex(char ch) {
    return isdigit(ch) ? ch - '0' : tolower(ch) - 'a' + 10;
}
 
 
unsigned char to_hex(unsigned char code) 
{
    static unsigned char hex[] = "0123456789ABCDEF";
    return hex[code & 15];
}
 
 
int url_encode(char *str, int ext)
{
    unsigned char *pstr = (unsigned char *)str;
    unsigned char  buf[MAX_URL_LEN] = {0};
    unsigned char *pbuf = buf;

    printf("orignal str:%s\n", str);

    while (*pstr && (pbuf - buf + 4) < MAX_URL_LEN)
    {
        /* Allow only alphanumeric chars and '_', '-', '.'; escape the rest */
        /** Come from php source code. */
        if (isalnum(*pstr) || NULL != strchr("_-.~", *pstr)
            || (ext && NULL != strchr("%?&=/:", *pstr)))
        {
            *pbuf++ = *pstr;
        }
        else if (*pstr == ' ')
        {
            *pbuf++ = '+';
        }
        else
        {
            *pbuf++ = '%';
            *pbuf++ = to_hex(*pstr >> 4);
            *pbuf++ = to_hex(*pstr & 15);
        }

        pstr++;
    }
    *pbuf = '\0';

    printf("encode: %s\n", buf);

    snprintf(str, MAX_URL_LEN, "%s", buf);

    return 0;
}
 
char *url_decode(char *str) {
  char *pstr = str, *buf = malloc(strlen(str) + 1), *pbuf = buf;
  while (*pstr) {
    if (*pstr == '%') {
      if (pstr[1] && pstr[2]) {
        *pbuf++ = from_hex(pstr[1]) << 4 | from_hex(pstr[2]);
        pstr += 2;
      }
    } else if (*pstr == '+') { 
      *pbuf++ = ' ';
    } else {
      *pbuf++ = *pstr;
    }
    pstr++;
  }
  *pbuf = '\0';
  return buf;
}

int print_agrs(int argc, char *argv[])
{
    int i = 0;
    if (argc > 0)
    {
        for (i = 0; i < argc; i++)
        {
            printf("This %d argument is %s.\n", i, argv[i]);
        }
    }

    return 0;
}

int main(int argc, char *argv[])
{
    unsigned char url[MAX_URL_LEN]="......?---陈毓端06/23/2009 北京.";

    print_agrs(argc, argv);

    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(url, MAX_URL_LEN, "%s", argv[1]);
    }

    url_encode(url, 1);
    printf ("value:%s\n", url);

    return 0;
}
