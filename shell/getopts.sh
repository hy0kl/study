#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

show_usage()
{
    # echo -e "`printf %-16s `"
    echo -e "Usage: $0 -c .. set config"
    echo -e "-v show version and exit"
    echo -e "-h show help and exit"
}

show_version()
{
    echo "version: 1.0"
    echo "updated date: 2014-09-17"
}

arg_conf=''

while getopts "c:vh" arg #选项后面的冒号表示该选项需要参数
do
    case $arg in
        c)
            arg_conf=$OPTARG
            ;;
        h)
            show_usage
            exit
            ;;
        v)
            show_version
            exit
            ;;
        ?)  #当有不认识的选项的时候arg为?
            echo -e "\033[31munkonw argument\033[0m"
            exit 1
            ;;
        *)
            echo -e "\033[31mERROR: unknown argument! \033[0m\n" && show_usage && exit 1
            ;;
    esac
done

echo "config is: $arg_conf"

