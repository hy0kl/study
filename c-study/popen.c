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

#define LINE_BUF_LEN    1024
#define OUTPUT_BUF_LEN  102400

int main(int argc, char *argv[])
{
    int   rc = 0;
    FILE *fp;
    char  line_buf[LINE_BUF_LEN];
    char  cmd_buf[LINE_BUF_LEN];
    char  output_buf[OUTPUT_BUF_LEN];

    output_buf[0] = '\0';
    if (argc > 1) {
        snprintf(cmd_buf, LINE_BUF_LEN, "%s", argv[1]);
    } else {
        snprintf(cmd_buf, LINE_BUF_LEN, "cd ~/ && ls -la");
    }
    //fp = popen("cd ~/ && ls -la", "r");
    //fp = popen("ls -l nofile.txt 2>&1", "r");
    fp = popen(cmd_buf, "r");
    if (NULL == fp) {
        fprintf(stderr, "Can NOT popen().\n");
        exit(110);
    }

    while (strlen(output_buf) < sizeof(output_buf) - sizeof(line_buf) && NULL != fgets(line_buf, sizeof(line_buf) - 1, fp)) {
        strncat(output_buf, line_buf, strlen(line_buf));
    }

    rc = pclose(fp);
    int status_child = WEXITSTATUS(rc);

    if (EXIT_SUCCESS == status_child) {
        printf("子进程执行成功! <-> ");
    } else {
        printf("子进程执行失败! <-> ");
    }

    printf("子进程的执行结果: \n\n%s\n---end--\n", output_buf);

    return EXIT_SUCCESS;
}

/* vi:set ft=c ts=4 sw=4 et fdm=marker: */

