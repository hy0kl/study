#include <stdio.h>
#include <stdlib.h>
#include <sys/socket.h>
#include <strings.h>
#include <sys/epoll.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <sys/wait.h>
#include <fcntl.h>
#include <unistd.h>
#include <errno.h>
#include <time.h>
#include <sys/time.h>
#include <fcntl.h>

#define DEBUG 1

#define MAXLINE     1024 * 100
#define OPEN_MAX    100
#define LISTENQ     20
#define SERV_PORT   5000
#define INFTIM      1000

#define DEFAULT_PORT 8989
#define DEFAULT_HOST "127.0.0.1"
#define HOSTNAME_LEN 256

#define EVENTS_NUM  20
#define EPOOL_FD    1024 * 4
#define EPOOL_TIMEOUT 100
#define DAEMON      0
