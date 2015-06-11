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

#include <zdb.h>

// gcc -o mysql-pool mysql-pool.c -lzdb -I$HOME/local/include/zdb

int main(int argc, char *argv[])
{

    URL_T url = URL_new("mysql://127.0.0.1:3306/oauth2?user=dev&password=dev");
    ConnectionPool_T pool = ConnectionPool_new(url);
    ConnectionPool_start(pool);

    Connection_T con = ConnectionPool_getConnection(pool);

    TRY
    {
        ResultSet_T result = Connection_executeQuery(con,
            "SELECT access_token, client_id, user_id, expires FROM oauth_access_tokens");
        while (ResultSet_next(result))
        {
            const char *access_token = ResultSet_getStringByName(result, "access_token");
            printf("%s\t", access_token);

            const char *client_id = ResultSet_getStringByName(result, "client_id");
            printf("%s\t", client_id);

            printf("\n");
        }
    }
    CATCH(SQLException)
    {
        printf("SQLException -- %s\n", Exception_frame.message);
    }
    FINALLY
    {
        Connection_close(con);
    }
    END_TRY;

    return 0;
}

/* vi:set ft=c ts=4 sw=4 et fdm=marker: */

