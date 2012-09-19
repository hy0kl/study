#!/bin/sh
#set -x

cd $HOME/src 
ret=$?

# download new version
need="pcre.tar.gz openssl.tar.gz nginx.tar.gz"
tar_src=("ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.31.tar.gz" "http://www.openssl.org/source/openssl-1.0.1c.tar.gz" "http://nginx.org/download/nginx-1.2.3.tar.gz")

i=0
for check in $need
do
    if [ -f "$check" ];then
        echo "$check is already exist."
    else
        echo "$check does not exist, need download from remote: ${tar_src[$i]}"
        wget "${tar_src[$i]}" -O $check
    fi

    i=$((i + 1))
done

if ((0 == ret))
then
    tar -zxf pcre.tar.gz
    tar -zxf openssl.tar.gz
    tar -zxf zlib-1.2.5.tar.gz
    tar -zxf nginx.tar.gz 
    cd nginx-1.2.3
    #./configure --prefix=$HOME/nginx --with-http_realip_module --with-http_sub_module --with-http_flv_module --with-http_dav_module --with-http_gzip_static_module --with-http_stub_status_module --with-http_addition_module --with-pcre=$HOME/src/pcre-8.31 --with-openssl=$HOME/src/openssl-1.0.1c --with-http_ssl_module --with-zlib=$HOME/src/zlib-1.2.5
    ./configure --prefix=$HOME/nginx --with-http_realip_module --with-http_sub_module --with-http_flv_module --with-http_dav_module --with-http_gzip_static_module --with-http_stub_status_module --with-http_addition_module --with-pcre=$HOME/src/pcre-8.31 --with-zlib=$HOME/src/zlib-1.2.5
    make
    make install
fi
