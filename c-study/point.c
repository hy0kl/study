#include <stdio.h>
#include <string.h>

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
    int ret = -9;

    test(&t);

    printf("Now, t is: %d in %s.\n", t, __FUNCTION__);

    int (*fun)(const char *s1, const char *s2, size_t n) = NULL;
    fun = strncmp;

    printf("Before cmp, ret is: %d\n", ret);
    ret = fun("hello", "Test", 4);
    printf("After cmp, ret is: %d\n", ret);

    return 0;
}
