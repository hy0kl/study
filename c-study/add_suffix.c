#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX_URL_LEN_EXT 2048

int add_suffix4link(char *link, char *suffix);

int main(int argc, char *argv[])
{
    char str_buff[MAX_URL_LEN_EXT] = "http://dict.youdao.com/search?q=suffix";
    char suffix[MAX_URL_LEN_EXT] = "mp3";
    
    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(str_buff, MAX_URL_LEN_EXT, "%s", argv[1]);
    }

    if (argc > 2 && 0 != argv[2][0])
    {
        snprintf(suffix, MAX_URL_LEN_EXT, "%s", argv[2]);
    }

    printf("URL: %s\nsuffix: %s\n", str_buff, suffix);

    add_suffix4link(str_buff, suffix); 

    printf("After add suffix, URL: %s\n", str_buff);

    return 0;
}

int add_suffix4link(char *link, char *suffix)
{
    char str_buff[MAX_URL_LEN_EXT] = {0};
    char *p = str_buff;

    if (NULL == link || NULL == suffix)
    {
        return -1;
    }

    p += snprintf(p, MAX_URL_LEN_EXT, "%s", link);
    p += snprintf(p, MAX_URL_LEN_EXT - (p - str_buff), ".%s", suffix);

    if (snprintf(link, MAX_URL_LEN_EXT, "%s", str_buff) > 0)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

