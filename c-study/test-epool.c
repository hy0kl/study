#include <stdio.h>
#include <unistd.h>
#include <string.h>
#include <stdlib.h>
#include <sys/epoll.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <fcntl.h>
#include <errno.h>
#include <sys/wait.h>


#define PORT        6868 
#define BACKLOG     100
#define BUF_EV_LEN  150
#define MAX_EPOLL_FD 8000
#define HTML_BUF    1024

static char *policyXML = "<cross-domain-policy><allow-access-from domain=/\"*/\" to-ports=/\"*/\"/></cross-domain-policy>";
static char *policeRequestStr = "<policy-file-request/>";


int CreateTcpListenSocket();
int InitEpollFd();
void UseConnectFd(int sockfd);
void setnonblocking(int sock);

static int listenfd;

int main(int argc, char *argv[])
{
    signal(SIGPIPE, SIG_IGN);
    /**/pid_t pid;
 
    if((pid = fork()) < 0){
        printf("End at: %d",__LINE__);
        exit(-1);
    }
 
    if (pid){
        printf("End at: %d",__LINE__);
        exit(0);
    }
    run();

    return 0;
}

int run()
{
    int epoll_fd;
    int nfds;
    int i;
    
    struct epoll_event events[BUF_EV_LEN];
    struct epoll_event tempEvent;
    
    int sockConnect;
    struct sockaddr_in remoteAddr;
    int addrLen;
    
    addrLen = sizeof(struct sockaddr_in);
    epoll_fd = InitEpollFd();
    
    if (epoll_fd == -1)
    {
        printf("End at: %d,", __LINE__);
        perror("init epoll fd error.");
        exit(1);
    }
    
    printf("begin in loop.\n");
    while (1)
    {
        nfds = epoll_wait(epoll_fd, events, BUF_EV_LEN, 1000);
        //sleep(3);
        if(nfds > 5)
        {
            printf("connect num: %d\n", nfds);
        }

        if (nfds == -1)
        {
            printf("End at: %d, ",__LINE__);
            perror("epoll_wait error.");
            continue;
        }

        for (i = 0; i < nfds; i++)
        {
            if (listenfd == events[i].data.fd)
            {
                printf("connected success\n");
                sockConnect = accept(events[i].data.fd, (struct sockaddr*)&remoteAddr, &addrLen);
                if (sockConnect == -1)
                {
                    printf("End at: %d, ", __LINE__);
                    perror("accept error.");
                    continue;
                }
                setnonblocking(sockConnect);
                tempEvent.events = EPOLLIN | EPOLLET;
                tempEvent.data.fd = sockConnect;
                if (epoll_ctl(epoll_fd, EPOLL_CTL_ADD, sockConnect, &tempEvent) < 0)
                {
                    printf("End at: %d, ", __LINE__);
                    perror("epoll ctl error.");
                    return -1;
                }
            }
            else
            {
                UseConnectFd(events[i].data.fd);
            }
        }
    }

    printf("---------------------------------\n\n");
}

int CreateTcpListenSocket()
{
    int sockfd;
    struct sockaddr_in localAddr;
    if ((sockfd = socket(AF_INET, SOCK_STREAM, 0)) == -1)
    {
        printf("End at: %d, ", __LINE__);
        perror("create socket fail");
        return -1;
    }
    
    setnonblocking(sockfd);
    
    bzero(&localAddr, sizeof(localAddr));
    localAddr.sin_family = AF_INET;
    localAddr.sin_port = htons(PORT);
    localAddr.sin_addr.s_addr = htonl(INADDR_ANY);

    unsigned int optval;    
    //设置SO_REUSEADDR选项(服务器快速重起)
    optval = 0x1;
    setsockopt(sockfd, SOL_SOCKET, SO_REUSEADDR, &optval, 4);
    /*
    //设置SO_LINGER选项(防范CLOSE_WAIT挂住所有套接字)
    optval1.l_onoff = 0;
    optval1.l_linger = 1;
    setsockopt(listener, SOL_SOCKET, SO_LINGER, &optval1, sizeof(struct linger));

    int nRecvBuf=320*1024;//设置为320K
    setsockopt(listener ,SOL_SOCKET, SO_RCVBUF,(const char*)&nRecvBuf,sizeof(int));

    int nSendBuf=1024*1024;//设置为640K
    setsockopt(listener ,SOL_SOCKET, SO_SNDBUF,(const char*)&nSendBuf,sizeof(int));
    */
    if (bind(sockfd,  (struct sockaddr*)&localAddr, sizeof(struct sockaddr)) == -1)
    {
        perror("bind error");
        printf("End at: %d\n", __LINE__);
        return -1;
    }
    
    if (listen(sockfd, BACKLOG) == -1)
    {
        perror("listen error");
        printf("End at: %d\n", __LINE__);
        return -1;
    }
    
    return sockfd;
}

int InitEpollFd()
{
    struct rlimit rt;
    rt.rlim_max = rt.rlim_cur = MAX_EPOLL_FD;

    if (setrlimit(RLIMIT_NOFILE, &rt) == -1)
    {
        //perror("setrlimit");
        printf("<br/>     RLIMIT_NOFILE set FAILED: %s     <br/>", strerror(errno));
        //exit(1);
    }
    else 
    {
        printf("设置系统资源参数成功！/n");
    }
    
    //epoll descriptor
    int s_epfd;
    struct epoll_event ev;
    
    listenfd = CreateTcpListenSocket();
    
    if (listenfd == -1)
    {
        perror("create tcp listen socket error");
        printf("End at: %d\n", __LINE__);
        return -1;
    }
    
    s_epfd = epoll_create(MAX_EPOLL_FD);
    ev.events = EPOLLIN;
    ev.data.fd = listenfd;
    if (epoll_ctl(s_epfd, EPOLL_CTL_ADD, listenfd, &ev) < 0)
    {
        perror("epoll ctl error");
        printf("End at: %d\n",__LINE__);
        return -1;
    }
    
    return s_epfd;
}

void UseConnectFd(int sockfd)
{
    int buffer_size = HTML_BUF;
    char recvBuff[HTML_BUF];
    int recvNum = 0;
    int buff_size = buffer_size * 10;
    char *buff = calloc(1, buff_size);
    
    while(1){
        //memset(recvBuff,'/0',buffer_size);
        recvNum = recv(sockfd, recvBuff, buffer_size, MSG_DONTWAIT);
        
        if ( recvNum < 0) 
        {
            if (errno == ECONNRESET || errno == ETIMEDOUT) {//ETIMEDOUT可能导致SIGPIPE
                close(sockfd);
            }
            break;
        } else if (recvNum == 0) {
            close(sockfd);
            break;
        }
        
        //数据超过预定大小，则重新分配内存
        if(recvNum + strlen(buff) > buff_size)
        {
            if((buff=realloc(buff,buff_size+strlen(buff))) == NULL)
            {
                break;
            }
        }
        recvBuff[recvNum] = '\0';
        sprintf(buff,"%s%s", buff, recvBuff);
        //printf("%s/n",recvBuff);

        if(recvNum < buffer_size)
        {   
            break;
        }
    }

    if(recvBuff[0] == '0') printf("%s\n", buff);
    
    if(strcmp(buff, policeRequestStr) == 0)
    {
        sendMsg(sockfd, policyXML);
    }else if(strlen(buff) > 0)
    {
        sendMsg(sockfd, buff);
    }
    
    if (buff)
    {
        free(buff);
    }

    return;
}

void setnonblocking(int sock)
{
    int opts;   
    opts = fcntl(sock, F_GETFL);
    if(opts < 0)  
    {   
        perror("fcntl(sock,GETFL)");
        printf("End at: %d", __LINE__);
        exit(1);
    }
    
    opts = opts | O_NONBLOCK; 
    if(fcntl(sock, F_SETFL, opts) < 0)  
    {   
        perror("fcntl(sock,SETFL,opts)");
        printf("End at: %d", __LINE__);
        exit(1);    
    }    

    return;
}

//发送消息给某个连接
int sendMsg(int fd,char *msg)
{
    if(fd < 1) return 0;
    while(1)
    {
        int l = send(fd, msg, strlen(msg) + 1, MSG_DONTWAIT); 

        if(l < 0)
        {
            if(errno == EPIPE)
            {
                printf(">Send pipe error: %d\n", errno);
                printf("%d will close and removed at line %d!\n", fd, __LINE__);
                printf(">Send pipe error, %d closed!\n", fd);
                return -1;
            }
            break;
        }
        if (l <= strlen(msg) + 1)
        {
            //printf("消息'%s'发送失败！错误代码是%d，错误信息是'%s'/n", msg, errno, strerror(errno));
            //return -1;
            break;
        }
    }
    return 1;
}

