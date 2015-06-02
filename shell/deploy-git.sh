#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

user="work"
# 一组服务器列表,可以单独写文件,用 cat 读进来
hosts_conf='192.168.64.9'
path="/home/work/www/demo"

VERSION="1.0.0 2015.05"
# _     _     _
#| |__ (_)___| |_ ___  _ __ _   _
#| '_ \| / __| __/ _ \| '__| | | |
#| | | | \__ \ || (_) | |  | |_| |
#|_| |_|_|___/\__\___/|_|   \__, |
#
# 1. 2015.05.13 完成第一版

# terminal color
    red=$'\e[1;31m'
  green=$'\e[1;32m'
 yellow=$'\e[1;33m'
   blue=$'\e[1;34m'
magenta=$'\e[1;35m'
   cyan=$'\e[1;36m'
  white=$'\e[1;37m'
 normal=$'\e[m'

function show_usage()
{
    echo ""
    echo "${cyan}-----USAGE----${normal}"
    echo "${blue}$0 ${green}deploy ${yellow}                 ${red}deploy project with latest <head>.${normal}"
    echo "${blue}$0 ${green}rollback ${yellow}<head>         ${red}rollback with <head>.${normal}"
    echo ""
}

if [ $# -lt 1 ];then
    show_usage
    exit 1
fi

opt=$1
if [ 'deploy' != "$opt" ] && [ 'rollback' != "$opt" ]
then
    echo "${red}Lost args ...${normal}"
    show_usage
    exit -1
fi


if [ 'deploy' == "$opt" ]
then
    for host in $hosts_conf
    do
        ssh $user@$host "cd $path && git pull && git log -1 | awk '{if (\$1 ~/commit/) {print \$2}}'"

        ret=$?
        if [ 0 != $ret ]
        then
            echo "${red}deploy fail for: [$host]${normal}"
            exit -11
        else
            echo "${green}deploy success for: [$host]${normal}"
        fi
    done

    echo "${green}deploy success all.${normal}"
elif [ 'rollback' == "$opt" ]
then
    if [ $# -lt 2 ];then
        echo "${red}Lost <head> ...${normal}"
        show_usage
        exit 1
    fi

    refs_head=$2
    for host in $hosts_conf
    do
        ssh $user@$host "cd $path && git reset --hard $refs_head && git log -1 | awk '{if (\$1 ~/commit/) {print \$2}}'"

        ret=$?
        if [ 0 != $ret ]
        then
            echo "${red}rollback fail for: [$host]${normal}"
            exit -12
        else
            echo "${green}rollback success for: [$host]${normal}"
        fi
    done

    echo "${green}rollback success all.${normal}"
fi

exit 0

