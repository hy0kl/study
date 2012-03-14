#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>

#define DEBUG

#ifdef DEBUG
#define _fdebug(format, args...) \
    do { \
        fprintf(stderr, "[debug %s:%d] [%s %s]: ", __FILE__, __LINE__, __DATE__, __TIME__); \
        fprintf(stderr, format, ##args); \
    }while(0)
#else
#define _fdebug(format, args...) \
    do {}while(0)
#endif

int _debug(const char *format, ...)
{
#ifdef DEBUG
    va_list ap;
    va_start(ap, format);
    
    printf("[debug] [%s %s]: ", __DATE__, __TIME__);
    //fprintf(stderr, "[debug] [%s %s]: ", __DATE__, __TIME__);
    //fflush(stderr);
    //fprintf(stderr, format, ap);
    vprintf(format, ap);

    va_end(ap);
#endif

    return 0;
}

int main(int argc, char *agrv[])
{
    _debug("test%d int     %d  \n", 1, 0x123);
    _debug("test%d char    %c  \n", 2, 'g');
    _debug("test%d float   %.2f\n", 3, 123.4567);
    _debug("test%d double  %lf \n", 4, 123.45678901);
    _debug("test%d long    %ld \n", 5, 123456789);
    _debug("test%d string  %s  \n", 5, "Am I right?");

    char * p = "pointer";
    _debug("test%d pointer %p  \n", 6, p);
    _debug("test%d string  %s  \n", 7, p);

    _debug("test%d %s %d, %f, %c%s\n", 8, "This is a test:", 123, 45.678, 'G', "ood!");
    
    _fdebug("test%d %s %d, %f, %c%s\n", 9, "This is a test:", 12345, 11.121, 'K', " good!");

    return 0;
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
