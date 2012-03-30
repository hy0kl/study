#include <stdio.h>

int test(int *fd)
{
    int t = *fd;
    printf("The t is: %d in %s.\n", t, __FUNCTION__);

    *fd = 1024;
    return 0;
}

int main(int argc, char *argv[])
{
    int t = 128;
    test(&t);

    printf("Now, t is: %d in %s.\n", t, __FUNCTION__);

    return 0;
}
