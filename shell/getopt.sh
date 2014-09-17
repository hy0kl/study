#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

# 此脚本在 linux 下可以正常运行, bsd 系统不成.
# OK: Linux dev 3.13.0-32-generic #57-Ubuntu SMP Tue Jul 15 03:51:08 UTC 2014 x86_64 x86_64 x86_64 GNU/Linux
# NOT OK: Darwin MacPro.local 13.3.0 Darwin Kernel Version 13.3.0: Tue Jun  3 21:27:35 PDT 2014; root:xnu-2422.110.17~1/RELEASE_X86_64 x86_64

# @see: http://www.cnblogs.com/FrankTan/archive/2010/03/01/1634516.html
# http://my.oschina.net/leejun2005/blog/202376

# A small example program for using the new getopt(1) program.
# This program will only work with bash(1)
# An similar program using the tcsh(1) script language can be found
# as parse.tcsh

# Example input and output (from the bash prompt):
# ./parse.bash -a par1 'another arg' --c-long 'wow!*\?' -cmore -b " very long "
# Option a
# Option c, no argument
# Option c, argument `more'
# Option b, argument ` very long '
# Remaining arguments:
# --> `par1'
# --> `another arg'
# --> `wow!*\?'

# Note that we use `"$@"' to let each command-line parameter expand to a
# separate word. The quotes around `$@' are essential!
# We need TEMP as the `eval set --' would nuke the return value of getopt.

# $0 ： ./test.sh,即命令本身，相当于C/C++中的argv[0]
# $1 ： -f,第一个参数.
# $2 ： config.conf
# $3, $4 ... ：类推。
# $#  参数的个数，不包括命令本身，上例中$#为4.
# $@ ：参数本身的列表，也不包括命令本身，如上例为 -f config.conf -v --prefix=/home
# $* ：和$@相同，但"$*" 和 "$@"(加引号)并不同，"$*"将所有的参数解释成一个字符串，而"$@"是一个参数数组。

# -o 表示短选项，两个冒号表示该选项有一个可选参数，可选参数必须紧贴选项
# 如-carg 而不能是-c arg
# --long表示长选项
# "$@"在上面解释过
# -n:出错时的信息
# -- ：举一个例子比较好理解：
# 我们要创建一个名字为 "-f"的目录你会怎么办？
# mkdir -f #不成功，因为-f会被mkdir当作选项来解析，这时就可以使用
# mkdir -- -f 这样-f就不会被作为选项。

show_usage()
{
    # echo -e "`printf %-16s `"
    echo -e "Usage: $0 [-h|--help]"
    echo -e "[-v|-V|--version]"
    echo -e "[-l|--list ... ]"
    echo -e "[-c|--config ... ]"
    echo -e "[-i|--ignore]"
}

show_version()
{
    echo "version: 1.0"
    echo "updated date: 2014-09-17"
}

LIST='list'
CONFIG_FILE='config'
IGNRFLAG='noignr'

# 入口参数分析
TEMP=`getopt -o hvVl:c:i --long help,version,list:,config:,ignore -- "$@" 2>/dev/null`

[ $? != 0 ] && echo -e "\033[31mParse ERROR: unknown argument! \033[0m\n" && show_usage && exit 1

# 会将符合getopt参数规则的参数摆在前面，其他摆在后面，并在最后面添加--
eval set -- "$TEMP"

while :
do
    [ -z "$1" ] && break;
    case "$1" in
        -h|--help)
            show_usage; exit 0
            ;;
        -v|-V|--version)
            show_version; exit 0
            ;;
        -l|--list)
            LIST=$2; shift 2
            ;;
        -c|--config)
            CONFIG_FILE=$2; shift 2
            ;;
        -i|--ignore)
            IGNRFLAG="ignr"; shift
            ;;
        --)
            shift
            continue
            ;;
        *)
            echo -e "\033[31mERROR: unknown argument! \033[0m\n" && show_usage && exit 1
            ;;
    esac
done

echo "LIST        = $LIST";
echo "CONFIG_FILE = $CONFIG_FILE"
echo "IGNRFLAG    = $IGNRFLAG"

