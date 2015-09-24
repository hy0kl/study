#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

fifo="/tmp/$$.fifo"  #建立管道$$表示shell分配的进程号
mkfifo $fifo
exec 6<>$fifo        #将fifo的fd与6号fd绑定
thread_num=8         #启动的进程个数
count=0;
#预分配资源
while [[ $count -lt $thread_num ]]; do
  echo >&6
  #let count=count+1
  count=$((count + 1 ))
done
#任务列表
file_list=$1
for file in $file_list
do
  read -u6       #请求一个资源
  {
    echo "Task Begin"
    sleep 1
    echo $file   #任务
    echo "Task End"
    # produce a cook
    echo >&6     #完成任务，释放一个资源
  }&             #后台执行
done
wait             #等待所有的任务完成
exec 6>&-        #关闭fd 6描述符
rm $fifo
