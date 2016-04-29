#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x
test="abc"
{
[[ "$test"="abdc" ]]
    echo "OK"
echo "hhhh"
}

echo "www"
# vim:set ts=4 sw=4 et fdm=marker:

