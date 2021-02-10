#!/bin/sh

############################################################

# Nico Golde <nico(at)ngolde.de> Homepage: http://www.ngolde.de

# see: https://zh.wikipedia.org/zh-cn/ANSI%E8%BD%AC%E4%B9%89%E5%BA%8F%E5%88%97
# https://www.jianshu.com/p/790fc612aaa5

############################################################

for attr in 0 1 4 5 7 ; do
    echo "----------------------------------------------------------------"
    printf "ESC[%s;Foreground;Background - \n" $attr

    for fore in 30 31 32 33 34 35 36 37; do
        for back in 40 41 42 43 44 45 46 47; do
            printf '\033[%s;%s;%sm %02s;%02s  ' $attr $fore $back $fore $back
            printf '\033[0m'
        done

        printf '\n'
    done

    printf '\033[0m'
done

