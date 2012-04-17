#include <stdio.h>
#include <string.h>

#define DEFAULT_LINK_LENGTH 1024
#define LABLE_SIZE_MB       "MB"
#define LABLE_SIZE_KB       "KB"

int format_size(char *buf, float size)
{
    int ret = 0;
    float f = 0;
    if (NULL == buf || size <= 0)
    {   
        ret = -1; 
        goto FINISH;
    }   

    if ((f = size / 1048576) >= 1.0)
    {   
        snprintf(buf, DEFAULT_LINK_LENGTH, "%.2f%s", f, LABLE_SIZE_MB); 
    }   
    else if ((f = size / 1024) >= 1.0)
    {   
        snprintf(buf, DEFAULT_LINK_LENGTH, "%.2f%s", f, LABLE_SIZE_KB);
    }   
    else
    {   
        snprintf(buf, DEFAULT_LINK_LENGTH, "%.2fB", size); 
    }   

FINISH:
    return ret; 
}

int main(int argc, char *argv[])
{
    char buf[DEFAULT_LINK_LENGTH];
    float size = 100;
    int i = 0;

    for (i = 0; i < 50; i++)
    {
        format_size(buf, size);
        printf("%f format_size %s\n", size, buf);
        size += 1024 * 50;
    }

    return 0;
}
