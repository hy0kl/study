#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

arg_a=''
arg_b=''
arg_c=''

while getopts "a:bc" arg #选项后面的冒号表示该选项需要参数
do
    case $arg in
         a)
            arg_a=$OPTARG
            echo "a's arg:$OPTARG" #参数存在$OPTARG中
            ;;
         b)
            arg_b=$OPTARG
            echo "b"
            ;;
         c)
            arg_c=$OPTARG
            echo "c"
            ;;
         ?)  #当有不认识的选项的时候arg为?
            echo "unkonw argument"
            exit 1
            ;;
    esac
done

echo "arg_a=$arg_a"
echo "arg_b=$arg_b"
echo "arg_c=$arg_c"

