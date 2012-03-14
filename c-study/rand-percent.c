#include <ctype.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int get_percent_ret(int percent)
{
    if (percent >= 100)
    {
        return 1;
    }
    if (percent <= 0)
    {
        return 0;
    }

    int other = 100 - percent;
    int container[2];

    container[0] = other;
    container[1] = percent;

    int find = 0;
    int rand_index = rand() % 2;
    int rand_percent = rand() % 100;

    if (0 == rand_percent)
    {
        return 0;
    }
    
    int tmp_percent = 0;
    int i = 0;

    printf("rand_index = %d, rand_percent = %d%%\t", rand_index, rand_percent);
    
    for (; i < 2; i++)
    {
        tmp_percent += container[i];
        printf("tmp_percent = %d\t", tmp_percent);
        if (rand_percent <= tmp_percent)
        {
            find = i;
            break;
        }
    }

    return find;
}

int main(int argc, char *argv[])
{
    printf("The rand() RAND_MAX is: %d.\n", RAND_MAX);

    int i = 23;
    int j = 0;

    if (argc > 1 && 0 != argv[1][0])
    {
        i = atoi(argv[1]);
    }
    
    for (j = 0; j < 10000; j++)
    {
        int percent = get_percent_ret(i);
        printf("Current number is %d, get_percent_ret = %d\n", i, percent);
    }
        
    return 0;
}
