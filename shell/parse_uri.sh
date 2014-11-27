#!/bin/bash
# @describe:
# @author:   Jerry Yang(hy0kle@gmail.com)

#set -x

uri=`cat <<TEXT
/static/echo.css
/static/echo.js
/a.gif
/b.png
/c.jpg
/e.jpeg
/casef.JPG
TEXT
`

echo "$uri" | awk 'BEGIN{
    IGNORECASE = 1;
}
{
    # 利用变通的方式, IGNORECASE 不管用
    # LANG=C 也不管用.
    line = tolower($0);
    pos = match(line, /\.[(js)|(css)|(git)|(png)|(jpg)|(jpeg)]/);
    ext = substr($0, pos + 1);

    print pos, ext;
}'

