#!/bin/sh
set -x

cd src 
ret=$?

if ((0 == ret))
then
    tar -zxf pcre-8.12.tar.gz
    tar -zxf openssl-1.0.0d.tar.gz
    tar -zxf zlib-1.2.5.tar.gz
    tar -zxf nginx-1.1.0.tar.gz
    cd nginx-1.1.0
    ./configure --prefix=$HOME/nginx --with-http_realip_module \
                --with-http_sub_module \
                --with-http_flv_module \
                --with-http_dav_module \
                --with-http_gzip_static_module \
                --with-http_stub_status_module \
                --with-http_addition_module \
                --with-http_ssl_module \
                --with-pcre=$HOME/src/pcre-8.12 \
                --with-openssl=$HOME/src/openssl-1.0.0d \
                --with-zlib=$HOME/src/zlib-1.2.5
    make
    make install
fi
