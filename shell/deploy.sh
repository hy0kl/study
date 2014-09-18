#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

### 待部署项目的 svn 路径,根据需要修改 ###
svn_url="http://192.168.0.168/svn/app/trunk"

### 待部署的目标路径,项目根目录,根据需要修改 ###
des_path="./des_path"

# 项目名,可选的修改项
name="app"

VERSION="1.0 2014.09"

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
    echo "${cyan}-----USAGE----${normal}"
    echo "$0 update             ${red}deploy latest project.${normal}"
    echo "$0 tag ${yellow}tag-name${normal}       ${red}create deploy tag.${normal}"
    echo "$0 rollback ${yellow}tag-name${normal}  ${red}rollback with tag name.${normal}"
}

if [ $# -lt 1 ];then
    show_usage
    exit 1
fi

argc=$#
opt=$1

if [ 'update' != "$opt" ] && [ 'tag' != "$opt" ] && [ 'rollback' != "$opt" ]
then
    echo "${red}Lost args ...${normal}"
    show_usage
    exit -1
fi

# global vars
work_path=$(pwd)
src_dir="$work_path/source"
src_pro="$src_dir/$name"
backup="$src_dir/backup"
date_str=$(date +'%Y%m%d%H')

if [[ ! -d $des_path ]]
then
    echo "${red}$des_path DOES NOT exist, Can NOT exec deploy!${normal}"
    exit 1;
fi

if [[ ! -d $src_dir ]]
then
    echo "${magenta}$src_dir DOES NOT exist, create it.${normal}"
    mkdir -p $src_dir
fi

# svn up | co, get latest code
function get_code()
{
    # 切到工作目录
    cd $src_dir

    if [[ -d $name ]]
    then
        cd $name
        svn up
    else
        svn co $svn_url $name
    fi

    return 0
}

function create_tag()
{
    local argc=$#
    if ((1 != argc))
    then
        echo "${red}Lost tag name ...${normal}";
        show_usage
        exit 3
    fi

    local tag_name=$1

    # 切到执行目录
    cd $work_path

    local des_tag="$src_dir/$tag_name"

    if [[ -d $des_tag ]]
    then
        mv "$des_tag" "$des_tag.$date_str"
    fi

    # 产出待同步的文件
    cp -r $src_pro $des_tag
    find $des_tag -name '.svn' | xargs rm -rf

    echo "${green}create tag $tag_name success.${normal}"
    return 0
}

function rollback()
{
    local argc=$#
    if ((1 != argc))
    then
        echo "${red}Lost rollback tag name ...${normal}";
        show_usage
        exit 4
    fi

    local tag_name=$1

    # 切到执行目录
    cd $work_path

    local des_tag="$src_dir/$tag_name"
    if [[ ! -d "$des_tag" ]]
    then
        echo "${red}Can NOT find rollback tag name: $tag_name${normal}";
        exit 5
    fi

    # ! 注意 " 引号
    rsync -a "$des_tag/"* "$des_path"

    echo "${green}rollback success: ${cyan}$tag_name${normal}"
    return 0
}

# 更新最新版本
function update_project()
{
    get_code

    # 切回执行目录
    cd $work_path

    if [[ -d $backup ]]
    then
        rm -rf $backup
    fi

    # 产出待同步的文件
    cp -r $src_pro $backup
    find $backup -name '.svn' | xargs rm -rf

    # 同步文件
    # 目录不能用 " 引起来
    rsync -a "$backup/"* "$des_path"

    echo "${green}deploy success.${normal}"
    return 0
}

if [ 'update' == "$opt" ]
then
    update_project
    create_tag "tag.$date_str"
elif [ 'tag' == "$opt" ]
then
    # check tag name
    if [ $# -lt 2 ];then
        echo "${red}Lost tag name...${normal}"
        show_usage
        exit 2
    fi

    create_tag $2
elif [ 'rollback' == "$opt" ]
then
    # check rollback tag name
    if [ $# -lt 2 ];then
        echo "${red}Lost rollback tag name...${normal}"
        show_usage
        exit 2
    fi

    rollback $2
fi

exit 0

