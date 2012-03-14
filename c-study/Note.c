1. C 语言中的标准输出文件:
    stdin
    stdout
    stderr
2. C 语言中字符串转数字
#include <stdlib.h>
int atoi(const char *nptr);
long atol(const char *nptr);
long long atoll(const char *nptr);
long long atoq(const char *nptr);

3. 初始化
#include <strings.h>
void bzero(void *s, size_t n);
DESCRIPTION
   The bzero() function sets the first n bytes of the byte area starting at s to zero.

#include <string.h>
void *memset(void *s, int c, size_t n);
DESCRIPTION
    The memset() function fills the first n bytes of the memory area pointed to by s with the constant bytec.

4. 字符串拷贝
NAME
    strcpy, strncpy - copy a string
SYNOPSIS
   #include <string.h>
   char *strcpy(char *dest, const char *src);
   char *strncpy(char *dest, const char *src, size_t n);
DESCRIPTION
   The strcpy() function copies the string pointed to by src (including the terminating '\0' character) to the array pointed to by dest.  The strings may not overlap, and the destination  string  dest  must  be large enough to receive the copy.
   The  strncpy() function is similar, except that not more than n bytes of src are copied. Thus, if there is no null byte among the first n bytes of src, the result will not be null-terminated.
   In the case where the length of src is less than that of n, the remainder of dest will be  padded  with nulls.

NAME
    memcpy - copy memory area
SYNOPSIS
   #include <string.h>
   void *memcpy(void *dest, const void *src, size_t n);
DESCRIPTION
   The  memcpy()  function  copies n bytes from memory area src to memory area dest.  The memory areas may not overlap.  Use memmove(3) if the memory areas do overlap.
   实践证明, strncpy 在拷完目标字符后,会加入 \0,但前提是缓冲区足够大.所以安全的调用方法是:
   strncpy(dst, src, sizeof(dst) - 1);
   更理想的方法是使用: size_t strlcpy(char *dst, const char *src, size_t size);
   它最多拷 size - 1 字符,自动加 \0,同时效率也高,因为当 src 长度远小于缓冲区,拷完字符后不会再将剩余的空间全部置为 \0.

5. 中文全角空格: 0xA1,在 C 语言中, GBK 字符要比较两个字节是否都为 oxA1.

6. NAME strcmp, strncmp - compare two strings
SYNOPSIS
    #include <string.h>
    int strcmp(const char *s1, const char *s2);
    int strncmp(const char *s1, const char *s2, size_t n);
DESCRIPTION
    The  strcmp()  function compares the two strings s1 and s2.  It returns an integer less than, equal to, or greater than zero if s1 is found, respectively, to be less than, to match, or be greater than s2.
    The strncmp() function is similar, except it only compares the first (at most) n characters of  s1  and s2.
RETURN VALUE
    The  strcmp() and strncmp() functions return an integer less than, equal to, or greater than zero if s1 (or the first n bytes thereof) is found, respectively, to be less than, to match, or  be  greater  than s2.

7. C 语言中调用 shell
NAME
    system - execute a shell command
SYNOPSIS
    #include <stdlib.h>
    int system(const char *string);
DESCRIPTION
    system()  executes  a  command  specified in string by calling /bin/sh -c string, and returns after the command has been completed.  During execution of the command, SIGCHLD will be blocked, and  SIGINT  and SIGQUIT will be ignored.
RETURN VALUE
    The  value  returned is -1 on error (e.g. fork failed), and the return status of the command otherwise.
    This latter return status is in the format specified in wait(2).  Thus, the exit code  of  the  command  will  be WEXITSTATUS(status).  In case /bin/sh could not be executed, the exit status will be that of a command that does exit(127).
    If the value of string is NULL, system() returns nonzero if the shell is available, and zero if not. system() does not affect the wait status of any other children.

8. 错误描述
NAME
    strerror, strerror_r - return string describing error code
SYNOPSIS
    #include <string.h>
    char *strerror(int errnum);
    int strerror_r(int errnum, char *buf, size_t n);
DESCRIPTION
    The  strerror() function returns a string describing the error code passed in the argument errnum, possibly using the LC_MESSAGES part of the current locale to select the appropriate language.  This string must  not  be modified by the application, but may be modified by a subsequent call to perror() or strerror().  No library function will modify this string.
    The strerror_r() function is similar to strerror(), but is thread safe. It returns the  string  in  the user-supplied buffer buf of length n.
RETURN VALUE
    The  strerror()  function returns the appropriate error description string, or an unknown error message if the error code is unknown.  The value of errno is not changed for a successful call, and is set to a nonzero  value  upon  error.  The strerror_r() function returns 0 on success and -1 on failure, setting errno.
EXAMPLE
    fprintf(stderr, "[Fatal Error] malloc for tids fail. (%s)\n", strerror(errno));

9. 标准 C 语言实用大全
    1). 指针是一个变量,并且它是一种特殊的变量,是用来存放其他变量地址的变量.
    2). 采用 & 操作符将指针指向对象变量的地址,而采用 * 操作来得到该对象变量.

10. 有用的 C 语言工具
工具    位于何处        所做工作
1).用于检查源代码的工具
cb                      C 程序美化器,在源文件中运行这个过滤器,可以使源文件有标准的布局和缩进格式.来自 Berkeley
indent                  与 cb 作用相同,来自 AT&T
cflow   GNU cflow       打印程序中调用者/被调用者的关系
cscope  编译器附带      一个基于 ASCII 码 c 程序的交互式浏览器.
ctags   /usr/bin        创建一个标签文件,供 vi 编辑器使用.标签文件能加快检查程序源文件的速度,方法是维护一个表,里面有绝大多数对象的位置.
lint    随编译器附带    C 程序检查器
sccs    /usr/ccs/bin    源代码版本控制系统
vgrind  /usr/bin        格式器,服务于打印漂亮的 C 列表
2).用于检查可执行文件的工具
dis     /usr/ccs/bin    目标代码反汇编工具
dump -Lv /usr/ccs/bin   打印动态链接信息
ldd     /usr/bin        打印文件所需要的动态
nm      /usr/ccs/bin    打印目标文件的符号表
strings /usr/bin        查看嵌入于二进制文件中的字符串
sum     /usr/bin        打印文件的检验和与程序块计数.
3).帮助调试的工具
truss   /usr/bin        trace 的 SVr4 版本,打印可执行文件所进行的系统调用.它可以用于查看二进制文件正在干什么,为什么阻塞或者失败,非常有用
ps      /usr/bin        显示进程的待征
ctrace                  修改源文件,文件执行时按行打印,对小程序实用
debugger                交互式调式器
file    /usr/bin        探知一个文件包住的内容(如可执行文件, 数据, ASCII, shell script, archive 等)
4).性能优化辅助工具
gprof   /usr/ccs/bin    显示调用图配置数据(确定计算密集的函数)
prof    /usr/ccs/bin    显示每个程序所消耗时间的百分比
tcov                    显示每条语句执行次数(确定一个函数中计算密集循环)
time    /usr/bin/time   显示程序所使用的实际时间和 CPU 时间 

11. 清除 stream 状态 
#include <stdio.h>
void
clearerr(FILE *stream);
DESCRIPTION
     The function clearerr() clears the end-of-file and error indicators for the stream pointed to by stream.

