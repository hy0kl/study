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

#define DEBUG 1

#define MAXLINE  1024 
#define OPEN_MAX 100
#define LISTENQ  20
#define SERV_PORT 5000
#define INFTIM 1000

#define DEFAULT_PORT 8900
#define DEFAULT_HOST "127.0.0.1"
#define HOSTNAME_LEN 256

#define EVENTS_NUM 20
#define EPOOL_FD 1024 
#define EPOOL_TIMEOUT 100

/**
 * gcc -g -o epool-server epoll-server-lx.c
 * */

void setnonblocking(int sock)
{
    int opts;

    opts = fcntl(sock, F_GETFL);
    if(opts < 0)
    {
        perror("fcntl(sock,GETFL)");
        exit(1);
    }
    
    opts = opts | O_NONBLOCK;
    if(fcntl(sock, F_SETFL, opts) < 0)
    {
        perror("fcntl(sock,SETFL,opts)");
        exit(1);
    }
}

int main(int argc, char *argv[])
{
    int i, maxi, listenfd, connfd, sockfd, epfd, nfds, portnumber;
    ssize_t n;
    char line[MAXLINE] = {0};
    socklen_t clilen;
    
    char local_addr[HOSTNAME_LEN] = DEFAULT_HOST;
    char str[MAXLINE] = {0};
    char html_buf[EPOOL_FD][MAXLINE]= {0};
    char *p = NULL;
    char *p_start = NULL;
    int pos = 0;

    //声明epoll_event结构体的变量,ev用于注册事件,数组用于回传要处理的事件
    struct epoll_event ev, events[EPOOL_FD];
    struct sockaddr_in clientaddr;
    struct sockaddr_in serveraddr;
    
        
    if (argc > 1)
    {
        if( (portnumber = atoi(argv[1])) < 0 )
        {
            fprintf(stderr, "Usage:%s portnumber\a\n", argv[0]);
            return 1;
        }
    }
    else
    {
        portnumber = DEFAULT_PORT;
        fprintf(stderr, "Use default portnumber: %d\a\n", DEFAULT_PORT);
    }

    if (-1 == gethostname(local_addr, HOSTNAME_LEN))
    {
        fprintf(stderr, "Can NOT get host name, Use default host: %s\n", DEFAULT_HOST); 
        snprintf(local_addr, HOSTNAME_LEN, "%s", DEFAULT_HOST);
    }

    //生成用于处理accept的epoll专用的文件描述符
    epfd = epoll_create(EPOOL_FD);

    if (-1 == (listenfd = socket(AF_INET, SOCK_STREAM, 0)))
    {
        fprintf(stderr, "Create socket if fail.\n");
        exit(1);
    }
#ifdef DEBUG
    else
    {
        fprintf(stdout, "Create socket is success.\n");
    }
#endif
    //把socket设 置为非阻塞方式
    setnonblocking(listenfd);

    //设置与要处理的事件相关的文件描述符
    ev.data.fd = listenfd;
    
    //设置要处理的事件类型
    ev.events = EPOLLIN | EPOLLET;
    //ev.events=EPOLLIN;

    //注册epoll事件
    if (epoll_ctl(epfd, EPOLL_CTL_ADD, listenfd, &ev) < 0)
    {
        fprintf(stderr, "Register epoll events is fail for socket.\n");
        exit(1);
    }
#ifdef DEBUG
    else
    {
        printf("Register epoll events is success for socket.\n");
    }
#endif
    bzero(&serveraddr, sizeof(serveraddr));
    
    serveraddr.sin_family = AF_INET;
    inet_aton(local_addr, &(serveraddr.sin_addr));//htons(portnumber);
    serveraddr.sin_port = htons(portnumber);

    if (-1 == bind(listenfd, (struct sockaddr *)&serveraddr, sizeof(serveraddr)))
    {
        fprintf(stderr, "bind ip and port is fail.\n");
        exit(1);
    }
#ifdef DEBUG
    else
    {
        printf("bind ip and port is success.\n");
    }
#endif
    if (-1 == listen(listenfd, LISTENQ))
    {
        fprintf(stderr, "listen ip and port is fail.\n");
        exit(1);
    }
#ifdef DEBUG
    else
    {
        printf("listen ip and port is success.\n");
    }
#endif   
    
    maxi = 0;
    for ( ; ; ) {
        //等待epoll事件的发生
        nfds = epoll_wait(epfd, events, EVENTS_NUM, EPOOL_TIMEOUT);
        
        //处理所发生的所有事件
        for(i = 0; i < nfds; ++i)
        {
            if(events[i].data.fd == listenfd)
            //如果新监测到一个SOCKET用户连接到了绑定的SOCKET端口，建立新的连接
            {
                connfd = accept(listenfd, (struct sockaddr *)&clientaddr, &clilen);
                if(connfd < 0)
                {
                    perror("connfd < 0");
                    exit(1);
                }

                setnonblocking(connfd);

                snprintf(str, MAXLINE, "%s", inet_ntoa(clientaddr.sin_addr));
                fprintf(stderr, "accapt a connection from: %s\n", str);
                
                //设置用于读操作的文件描述符
                ev.data.fd = connfd;
                //设置用于注测的读操作事件

                ev.events = EPOLLIN | EPOLLET;
                //ev.events=EPOLLIN;

                //注册ev
                epoll_ctl(epfd, EPOLL_CTL_ADD, connfd, &ev);
            }
            else if(events[i].events & EPOLLIN)//如果是已经连接的用户，并且收到数据，那么进行读入
            {
                //cout << "EPOLLIN" << endl;
                fprintf(stderr, "EPOLLIN read data\n");
                if ( (sockfd = events[i].data.fd) < 0)
                    continue;
                
                if ( (n = read(sockfd, line, MAXLINE)) < 0)
                {
                    if (errno == ECONNRESET)
                    {
                        close(sockfd);
                        events[i].data.fd = -1;
                    }
                    else
                    {
                        //std::cout<<"readline error"<<std::endl;
                        fprintf(stderr, "readline error\n");
                    }
                }
                else if (n == 0)
                {
                    close(sockfd);
                    events[i].data.fd = -1;
                }

                line[n] = '\0';
                //cout << "read " << line << endl;
                fprintf(stderr, "Read: %s\n", line);
                
                //设置用于写操作的文件描述符
                ev.data.fd = sockfd;

                //设置用于注测的写操作事件
                ev.events = EPOLLOUT | EPOLLET;
                //修改sockfd上要处理的事件为EPOLLOUT
                epoll_ctl(epfd,EPOLL_CTL_MOD,sockfd,&ev);
            }
            else if(events[i].events & EPOLLOUT) // 如果有数据发送
            {
                sockfd = events[i].data.fd;

                p = html_buf[i];
                p_start = p;
                //memset(p, 0, MAXLINE);
                *p_start = 0;

                //HTTP头
                p += snprintf(p, MAXLINE - (p - p_start), "HTTP/1.1 200 OK\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "Content-Type: text/html; charset=UTF-8\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "Connection: closed\r\n\r\n");
                
                //页面
                p += snprintf(p, MAXLINE - (p - p_start), "<html>\r\n<head>\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\">\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "</head>\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "<body style=\"background-color: rgb(229, 229, 229);\">\r\n");

                p += snprintf(p, MAXLINE - (p - p_start), "<center>\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "<H3>Connect stat</H3>\r\n");
                p += snprintf(p, MAXLINE - (p - p_start), "</center></body></html>\r\n");

                
                //write(sockfd, line, n);
                write(sockfd, p_start, p - p_start);
                fprintf(stderr, "Send data to client.\n");
               
                close(sockfd);

                //设置用于读操作的文件描述符
                ev.data.fd = sockfd;

                //设置用于注测的读操作事件
                ev.events = EPOLLIN|EPOLLET;
                
                //修改sockfd上要处理的事件为EPOLIN
                epoll_ctl(epfd, EPOLL_CTL_MOD, sockfd, &ev);
            }
        }
    }

    return 0;
}

/**
epoll程序都使用下面的框架：

for( ; ; )
{
    nfds = epoll_wait(epfd, events, 20, 500);
    for(i = 0; i < nfds; ++i)
    {
        if(events[i].data.fd == listenfd) //有新的连接
        {
            connfd = accept(listenfd, (struct sockaddr *)&clientaddr, &clilen); //accept这个连接
            ev.data.fd = connfd;
            ev.events = EPOLLIN | EPOLLET;
            epoll_ctl(epfd, EPOLL_CTL_ADD, connfd, &ev); //将新的fd添加到epoll的监听队列中
        }
        else if( events[i].events & EPOLLIN ) //接收到数据，读socket
        {
            n = read(sockfd, line, MAXLINE)) < 0    //读
            ev.data.ptr = md;     //md为自定义类型，添加数据
            ev.events = EPOLLOUT | EPOLLET;
            epoll_ctl(epfd, EPOLL_CTL_MOD, sockfd, &ev);//修改标识符，等待下一个循环时发送数据，异步处理的精髓
        }
        else if(events[i].events & EPOLLOUT) //有数据待发送，写socket
        {
            struct myepoll_data* md = (myepoll_data*)events[i].data.ptr;    //取数据
            sockfd = md->fd;
            send( sockfd, md->ptr, strlen((char*)md->ptr), 0 );        //发送数据
            ev.data.fd = sockfd;
            ev.events = EPOLLIN | EPOLLET;
            epoll_ctl(epfd, EPOLL_CTL_MOD, sockfd, &ev); //修改标识符，等待下一个循环时接收数据
        }
        else
        {
            //其他的处理
        }
    }
}
*/
