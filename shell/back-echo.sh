#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x
for i in {1..100}
do
  echo -ne "\rprogress: $i%"
  sleep 1
done
# print a new line
echo
# vim:set ts=4 sw=4 et fdm=marker:

