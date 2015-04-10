#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

### 待部署项目的 svn tags 路径 ###
svn_url=""

### 待部署的目标路径,项目根目录 ###
des_path=""

VERSION="1.0 2015.04"

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
    echo "${blue}$0 ${green}deploy ${yellow}tags des-path           ${red}deploy project with tags.${normal}"
    echo "${blue}$0 ${green}rollback ${yellow}des_path              ${red}rollback auto.${normal}"
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

if [ 'deploy' = "$opt" ]
then
    if [ $# -lt 3 ]
    then
        echo "${red}Lost deploy args ...${normal}"
        show_usage
        exit -2
    fi

    svn_url=$2
    des_path=$3

fi

if [ 'rollback' = "$opt" ]
then
    if [ $# -lt 2 ]
    then
        echo "${red}Lost rollback tag name...${normal}"
        show_usage
        exit -4
    fi

    des_path=$2
fi

if [ ! -d "$des_path" ]
then
    echo "${red}$des_path${normal} does NOT exist, please check out it."
    exit -3
fi

# global vars
pro_name=$(echo "$des_path" | awk -F "/" '{print $NF}')
work_path=$(pwd)
des_parent=$(dirname $des_path)
src_dir="$work_path/export-source" # svn export 的代码放在这

# 基本思路: 将 export 出源码同步到 backup 下,然后将 des_path mv 为 last,再将 backup mv 为 des_path.
# 回滚提时候将 des_path mv 为 backup,再将 last mv 为 des_path
backup="${des_parent}/${pro_name}-0"
last="${des_parent}/${pro_name}-1"
#date_str=$(date +'%Y-%m-%d %H:%M:%S') # 用户操作提示

if [[ ! -d $src_dir ]]
then
    echo "${magenta}$src_dir DOES NOT exist, create it.${normal}"
    mkdir -p $src_dir
fi

# svn export tags, get latest code
function get_code()
{
    svn export --force "$svn_url" "$src_dir"

    if [ 0 != $? ]
    then
        echo "svn export fail: $svn_url"
        exit -11
    fi

    return 0
}

# 回滚
function rollback()
{
    if [ ! -d "$last" ]
    then
        echo "last ${red}$last${normal} DOES NOT exist, please check out it.";
        exit -5
    fi

    mv "$des_path" "$backup"
    mv "$last" "$des_path"

    echo "${green}rollback success.${normal}"

    return 0
}

# 更新最新版本
function update_project()
{
    get_code

    # 同步文件
    # 目录不能用 " 引起来
    rsync -a --delete --partial "$src_dir/"* "$backup"

    # 部署时,本次待更新的将迭待下一次 last
    if [ -d "$last" ]
    then
        rm -rf "$last"
    fi

    mv "$des_path" "$last"
    mv "$backup" "$des_path"

    rm -rf "$src_dir"/*

    echo "${green}deploy success.${normal}"
    return 0
}

if [ 'deploy' == "$opt" ]
then
    update_project
elif [ 'rollback' == "$opt" ]
then
    rollback
fi

exit 0

