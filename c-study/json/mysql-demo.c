/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */

// gcc -o mysql-demo -g mysql-demo.c  -I /usr/local/mysql/include/ -L /usr/local/mysql/lib/ -l mysqlclient
// $ sudo ln -s /usr/local/mysql/lib/libmysqlclient.18.dylib /usr/local/lib/libmysqlclient.18.dylib

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

#include <mysql.h>

int main(int argc, char *argv[])
{
    MYSQL *conn_ptr;
    MYSQL_RES *res_ptr;
    MYSQL_ROW sqlrow;
    MYSQL_FIELD *fd;
    int res, i, j;

    conn_ptr = mysql_init(NULL);
    if (!conn_ptr) {
        return EXIT_FAILURE;
    }

    conn_ptr = mysql_real_connect(conn_ptr, "127.0.0.1", "dev", "dev", "oauth2", 3306, NULL, 0);
    if (conn_ptr) {
        res = mysql_query(conn_ptr, "SELECT * FROM oauth_access_tokens"); //查询语句
        if (res) {
            printf("SELECT error:%s\n",mysql_error(conn_ptr));
        } else {
            res_ptr = mysql_store_result(conn_ptr);             //取出结果集
            if(res_ptr) {
                printf("%lu Rows\n",(unsigned long)mysql_num_rows(res_ptr));
                j = mysql_num_fields(res_ptr);
                while((sqlrow = mysql_fetch_row(res_ptr)))  {   //依次取出记录
                    for(i = 0; i < j; i++)
                        printf("%s\t", sqlrow[i]);              //输出
                    printf("\n");
                }
                if (mysql_errno(conn_ptr)) {
                    fprintf(stderr,"Retrive error:s\n",mysql_error(conn_ptr));
                }
            }
            mysql_free_result(res_ptr);
        }
    } else {
        printf("Connection failed\n");
    }
    mysql_close(conn_ptr);

    return EXIT_SUCCESS;
}

/* vi:set ft=c ts=4 sw=4 et fdm=marker: */

