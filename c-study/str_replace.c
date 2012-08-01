#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define TMP_STR_BUF_LEN     2 * 1024
#define MAX_URL_LEN_EXT     1024

char * str_replace(char *src, size_t buf_size, char *replace, char *subject)
{
    char *p   = NULL;
    char *pcp = NULL;
    size_t s_len = 0;

    char t_buf[TMP_STR_BUF_LEN] = {0};

    if ( NULL == src || buf_size <= 0 || NULL == replace || NULL == subject)
    {
        goto FINISH;
    }

    s_len = strlen(subject);

    pcp = src;
    p   = strstr(src, subject);

    if (NULL == p)
    {
        goto FINISH;
    }

    while (NULL != p)
    {
        *p = '\0';
        strncat(t_buf, pcp, TMP_STR_BUF_LEN - strlen(t_buf) - 1);
        strncat(t_buf, replace, TMP_STR_BUF_LEN - strlen(t_buf) - 1);
        p += s_len;
        pcp = p;

        p   = strstr(pcp, subject);
    }

    if (pcp)
    {
        strncat(t_buf, pcp, TMP_STR_BUF_LEN - strlen(t_buf) - 1);
    }

    if (strlen(t_buf))
    {
        memmove(src, t_buf, buf_size - 1);
        src[buf_size - 1] = '\0';
    }

FINISH:
    return src;
}

int main(int argc, char *argv[])
{
    char str_buff[TMP_STR_BUF_LEN] = "http://dict.youdao.com/search?q=suffix";
    char replace[MAX_URL_LEN_EXT]  = "mp3";
    char subject[MAX_URL_LEN_EXT]  = "o";
    
    if (argc > 1 && 0 != argv[1][0])
    {
        snprintf(str_buff, TMP_STR_BUF_LEN, "%s", argv[1]);
    }

    if (argc > 2 && NULL != argv[2])
    {
        snprintf(replace, MAX_URL_LEN_EXT, "%s", argv[2]);
    }

    if (argc > 3 && 0 != argv[3][0])
    {
        snprintf(subject, MAX_URL_LEN_EXT, "%s", argv[3]);
    }

    printf("str_buff: %s\n replace: %s\n subject: %s\n", str_buff, replace, subject);

    str_replace(str_buff, TMP_STR_BUF_LEN, replace, subject); 

    printf("After replace, str_buf: %s\n", str_buff);

    return 0;
}
