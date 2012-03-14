/**
 * @file kmp.c
 * @author yangyongjie(com@baidu.com)
 * @date 2012/02/07 16:07:57
 * @brief
 *
 **/
#include <stdio.h>
#include <malloc.h>
#include <string.h>
#include <stdlib.h>

#define STR_BUF_LEN 1024
/**
“KMP算法中，如果当前字符匹配成功，即S[i]==T[j]，令i++，j++，继续匹配下一个字符；
如果匹配失败，即S[i] != T[j]，需要保持i不变，并且让j = next[j]，
这里next[j] <=j -1，即模式串T相对于原始串S向右移动了至少1位(移动的实际位数j - next[j]  >=1),
同时移动之后，i之前的部分（即S[i-j+1 ~ i-1]），和j=next[j]之前的部分（即T[0 ~ j-2]）仍然相等。
显然，相对于BF算法来说，KMP移动更多的位数，起到了一个加速的作用！
(失配的特殊情形，令j=next[j]导致j==0的时候，需要将i++，否则此时没有移动模式串)。”
*/

char haystack[STR_BUF_LEN] = "aaaaaaaaaaaaaaaaaaaaaaaaaab";
char pattern[STR_BUF_LEN]  = "aaaaaaaab";
int  next_map[STR_BUF_LEN] = {0};

void get_nextval(const char *ptrn, int plen, int *nextval)
{
    int i = 0;
    int j = -1;

    nextval[i] = -1;
    while (i < plen - 1)
    {
        if(-1 == j || ptrn[i] == ptrn[j])
        {
            ++i;
            ++j;
            if(ptrn[i] != ptrn[j])
            {
                nextval[i] = j;
            }
            else
            {
                nextval[i] = nextval[j];
            }
        }
        else
        {
            j = nextval[j];
        }
    }
}

int
kmp_search(const char *src, int slen, const char *patn, int plen,
    int const* nextval, int pos)
{
    int i = pos;
    int j = 0;

    while (i < slen && j < plen)
    {
        if (-1 == j || src[i] == patn[j])
        {
            ++i;
            ++j;
        }
        else
        {
            j = nextval[j];
        }
    }

    if(j >= plen)
    {
        return i - plen;
    }

    return -1;
}

int main(int argc, char *argv[])
{
    int haystack_len = 0;
    int pattern_len  = 0;
    int i;
    int pos;

    if (argc > 1 && argv[1][0])
    {
        snprintf(haystack, STR_BUF_LEN, "%s", argv[1]);
    }

    if (argc > 2 && argv[2][0])
    {
        snprintf(pattern, STR_BUF_LEN, "%s", argv[2]);
    }
    printf("haystack: %s\n", haystack);
    printf("pattern: %s\n", pattern);

    haystack_len = strlen(haystack);
    pattern_len  = strlen(pattern);

    get_nextval(pattern, pattern_len, next_map);
    for (i = 0; i < pattern_len; i++)
    {
       printf("next_map[%d] = %d\n", i, next_map[i]);
    }

    if (-1 != 
        (pos = kmp_search(haystack, haystack_len, pattern, pattern_len, next_map, 0)))
    {
        printf("OK, the pattern:[%s] is substr of haystack:[%s], position is:%d.\n",
            pattern, haystack, pos);
    }
    else
    {
        printf("Sorry, the pattern:[%s] is NOT substr of haystack:[%s].\n",
            pattern, haystack);
    }

    return 0;
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
