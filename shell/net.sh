#!/bin/bash

PROCNAME=pppd # ppp守护进程
PROCFILENAME=status
NOTCONNCTED=65
INTERVAL=2 # 两秒刷新一次

pidno=$(ps ax | grep -v "pa ax" | grep -v grep | grep $PROCNAME | awk '{print $1}');
# 搜索 ppp 守护进程 'pppd' 的进程号
# 一定要过滤掉由搜索进程产生的该行进程

# pidno=$(pidof $PROCNAME);    # 使用 pidof 命令相当的简单

if [ -z "$pidno" ]
then
    echo "Not connected."
    exit $NOTCONNECTED
else
    echo "Connected."
    echo
fi

while [ true ]
do
    if [ ! -e "/proc/$pidno/$PROCFILENAME" ]
    then
        echo "Disconnected."
        exit $NOTCONNECTED
    fi
    
    netstat -s | grep "packets received"    # 取得一些连接统计
    netstat -s | grep "packets delivered"
    
    sleep $INTERVAL
    
    echo;echo
    
done

exit 0
