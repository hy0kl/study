#include <stdio.h>
#include <stdlib.h>
 
char *toBinary(int num)
{
    char *binary = (char *)malloc(sizeof(char) * 33);
    int flag = 1;
    int i;
 
    for (i = 31; i >= 0; i--)
    {
        if (num & flag)
        {
            binary[i] = '1';
        }
        else
        {
            binary[i] = '0';
        }
        flag<<=1;
    }
    binary[32] = '\0';
 
    return binary;
}

int main() {
    char *tmp;
    for (int i = -16; i <= 16; i++) {
        tmp = toBinary(i);
        printf("%d:\t%s\n", i, tmp);
        free(tmp);
        tmp = NULL;
    }
 
    return 0;
}
