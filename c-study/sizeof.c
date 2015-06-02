#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define TMP_STR_BUF_LEN     2 * 1024

int main(int argc, char *argv[])
{
    char str_buff[TMP_STR_BUF_LEN] = "http://dict.youdao.com/search?q=suffix";
    char *p = NULL;
    int i = 1;
    float k = 123.456;
    int   *pi = NULL;
    float *pf = NULL;

    fprintf(stderr, "sizeof(char) = %lu\n", sizeof(char));
    fprintf(stderr, "sizeof(int) = %lu\n", sizeof(int));

    fprintf(stderr, "sizeof(char str_buff) = %lu\n", sizeof(str_buff));
    fprintf(stderr, "sizeof(char *p) = %lu\n", sizeof(p));
    fprintf(stderr, "sizeof(int i) = %lu\n", sizeof(i));
    fprintf(stderr, "sizeof(float k) = %lu\n", sizeof(k));
    fprintf(stderr, "sizeof(int *pi) = %lu\n", sizeof(pi));
    fprintf(stderr, "sizeof(float *pf) = %lu\n", sizeof(pf));

    p  = str_buff;
    pi = &i;
    pf = &k;

    fprintf(stderr, "After...\n");
    fprintf(stderr, "sizeof(char *p) = %lu\n", sizeof(p));
    fprintf(stderr, "sizeof(int *pi) = %lu\n", sizeof(pi));
    fprintf(stderr, "sizeof(float *pf) = %lu\n", sizeof(pf));

    fprintf(stderr, "sizeof(\"just\") = %lu\n", sizeof("just"));

    return 0;
}
