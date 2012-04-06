#include <stdio.h>
#include <string.h>

#define DEFAULT_TITLE_LENGTH 1024

int cut_str(const char *src, char *des, const char *charset, int length, const char *suffix)
{
    int ret = -1;
    int suffix_len = strlen(suffix);
    int str_len    = strlen(src);

    unsigned int t  = 0;
    int n  = 0;
    int tn = 0;

    if (NULL == src || NULL == des || length <= 0)
    {
        return -11;
    }

    if (str_len == length && str_len < DEFAULT_TITLE_LENGTH)
    {
        memmove(des, src, str_len);
        des[DEFAULT_TITLE_LENGTH - 1] = '\0';

        return 0;
    }

    length -= suffix_len;
    if (0 == strncmp(charset, "utf-8", 5))
    {
        while(n < length)
        {
            t = (unsigned char)src[n];
            if (t == 9 || t == 10 || (32 <= t && t <= 126))
            {
                tn = 1;
                n++;
            }
            else if (194 <= t && t <= 223)
            {
                tn = 2;
                n   += 2;
            }
            else if (224 <= t && t < 239)
            {
                tn = 3;
                n   += 3;
            }
            else if (240 <= t && t <= 247)
            {
                tn = 4;
                n   += 4;
            }
            else if (248 <= t && t <= 251)
            {
                tn = 5;
                n   += 5;
            }
            else if (t == 252 || t == 253)
            {
                tn = 6;
                n   += 6;
            } else
            {
                n++;
            }

            if(n >= length)
            {
                break;
            }

        }

        if(n > length)
        {
            n -= tn;
        }

        for (t = 0; t < n; t++)
        {
            des[t] = src[t];
        }
    }
    else
    {
        for(n = 0; n < length - 1; n++)
        {
            des[n] = src[n];
            t = (unsigned char)src[n];
            if (t  > 127)
            {
                n++;
                des[n] = src[n];
            }
        }

    }
    ret = n;

    strncat(des, suffix, DEFAULT_TITLE_LENGTH - strlen(des) - 1);
    des[DEFAULT_TITLE_LENGTH - 1] = '\0';

    return ret;
}

int main(int argc, char *argv[])
{
    char test_str[DEFAULT_TITLE_LENGTH] = "Hello, 如果这是全是中文,是不是会出现半个汉字呢?utf-8字符";
    char buf[DEFAULT_TITLE_LENGTH] = {0};

    int length = 16;

    if (argc > 1 && argv[1][0])
    {
        length = atoi(argv[1]);
        if (length <= 0)
        {
            length = 8;
            fprintf(stderr, "args length is wrong, use default value: %d.\n", length);
        }
    }

    cut_str(test_str, buf, "utf-8",  length, "...");
    printf("The cut length = %d\n", length);
    printf("[src:] %s\n[cut str:] %s\n", test_str, buf);
    printf("buf string len: %d\n", (int)strlen(buf));

    return 0;
}
