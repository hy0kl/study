#include <stdio.h>
#include <pthread.h>
#include <stdlib.h>
#include <unistd.h>

pthread_t ntid;

void printids(const char *s)
{
    pid_t pid;
    pthread_t tid;

    pid = getpid();
    tid = pthread_self();

    printf("%s pid = %u, tid = %u (0x%x)\n",
        s, (unsigned int)pid, (unsigned int)tid, (unsigned int)tid);
}

void *thr_fun(void *arg)
{
    printids("new thread: ");
    return ((void *)0);
}

int main(int argc, char *argv)
{
    int err;

    err = pthread_create(&ntid, NULL, thr_fun, NULL);
    if (0 != err)
    {
        fprintf(stderr, "Can NOT create thread: %s\n", strerror(err));
        return -1;
    }
    printids("main thread: ");
    sleep(1);

    return 0;
}
