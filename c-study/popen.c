/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include <stdarg.h>
#include <ctype.h>
#include <unistd.h>
#include <pthread.h>
#include <netdb.h>
#include <fcntl.h>
#include <time.h>
#include <assert.h>
#include <signal.h>
#include <errno.h>
#include <err.h>
#include <getopt.h>
#include <sys/time.h>
#include <sys/queue.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <sys/stat.h>
#include <sys/mman.h>
#include <sys/ioctl.h>

int main(int argc, char *argv[])
{
    FILE *fp;
    char line_buf[1024];
    char buffer[10240];

    buffer[0] = '\0';
    fp = popen("cd ~/ && ls -la", "r");
    while (NULL != fgets(line_buf, sizeof(line_buf) - 1, fp)) {
        strncat(buffer, line_buf, strlen(line_buf));
    }

    printf("子进程的执行结果: \n%s", buffer);
    pclose(fp);

    return 0;
}

/* vi:set ft=c ts=4 sw=4 et fdm=marker: */

