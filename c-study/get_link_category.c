#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define MAX_URL_LEN_EXT 2048
#define TYPE_SIZE 64

int get_link_category(const char *link, char *type, int size)
{
    if (NULL == link)
    {
        /** default type*/
        snprintf(type, size, "mp3");
        return -1;
    }

    if (strstr(link, ".rm"))
    {
        snprintf(type, size, "rm");
    }
    else if (strstr(link, ".ram"))
    {
        snprintf(type, size, "ram");
    }
    else if (strstr(link, ".mp3"))
    {
        snprintf(type, size, "mp3");
    }
    else if (strstr(link, ".wma")) 
    {
        snprintf(type, size, "wma");
    }
    else if (strstr(link, ".asf"))
    {
        snprintf(type, size, "asf");
    }
    else if (strstr(link, ".swf") || strstr(link, ".flash"))
    {
        snprintf(type, size, "swf");
    }
    else if (strstr(link, ".rtsp"))
    {
        snprintf(type, size, "rtsp");
    }
    else
    {
        snprintf(type, size, "mp3");
    }

    return 0;
}

int main(int argc, char *argv[])
{
    char str_buff[MAX_URL_LEN_EXT] = "http://dict.youdao.com/search?q=suffix.mp3&code=12qwas";
    char type[TYPE_SIZE] = {0};
    
    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(str_buff, MAX_URL_LEN_EXT, "%s", argv[1]);
    }

    printf("URL: %s\n", str_buff);

    get_link_category(str_buff, type, TYPE_SIZE); 

    printf("Finde type is: %s\n", type);

    return 0;
}

