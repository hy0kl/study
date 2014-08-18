#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

# 应用开发环境快速部署,本地同步
# 稍加改造即可升级上上线脚本.

# svn url 根据需要修改
svn_url="http://192.168.2.168/svn/admin/trunk"

# 待部署的目标路径,项目根目录
des_path="./des_path"

work_path=$(pwd)
name="project"

src_dir="$work_path/source"
src_pro="$src_dir/project"
backup="$src_dir/backup"

if [[ ! -d $des_path ]]
then
    echo "$des_path DOES NOT exist, Can NOT exec deploy!"
    exit 1;
fi

if [[ ! -d $src_dir ]]
then
    echo "$src_dir DOES NOT exist, create it."
    mkdir -p $src_dir
fi

# 切到工作目录
cd $src_dir

if [[ -d $name ]]
then
    cd $name
    svn up
else
    svn co $svn_url $name
fi

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
rsync -r $backup/* $des_path

echo "deploy success."

