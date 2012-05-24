#!/bin/sh
set -x

cd
mkdir src && cd src 
ret=$?

if ((0 == ret))
then

    scp mp3@tc-mp3-dxfgl02.tc.baidu.com:/home/mp3/src/pcre-8.12.tar.gz ./
    scp mp3@tc-mp3-dxfgl02.tc.baidu.com:/home/mp3/src/openssl-1.0.0d.tar.gz ./
    scp mp3@tc-mp3-dxfgl02.tc.baidu.com:/home/mp3/src/zlib-1.2.5.tar.gz ./
    scp mp3@tc-mp3-dxfgl02.tc.baidu.com:/home/mp3/src/nginx-1.1.0.tar.gz ./

    tar -zxf pcre-8.12.tar.gz
    tar -zxf openssl-1.0.0d.tar.gz
    tar -zxf zlib-1.2.5.tar.gz
    tar -zxf nginx-1.1.0.tar.gz
    cd nginx-1.1.0
    ./configure --prefix=/home/mp3/nginx --with-http_realip_module --with-http_sub_module --with-http_flv_module --with-http_dav_module --with-http_gzip_static_module --with-http_stub_status_module --with-http_addition_module --with-pcre=/home/mp3/src/pcre-8.12 --with-openssl=/home/mp3/src/openssl-1.0.0d --with-http_ssl_module --with-zlib=/home/mp3/src/zlib-1.2.5    make
    make install
fi
