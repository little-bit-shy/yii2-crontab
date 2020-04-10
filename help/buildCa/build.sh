#!/bin/sh

. new_ca.sh
. new_client.sh
. new_server.sh

clear(){
    rm -rf ./private
    rm -rf ./server
    rm -rf ./newcerts
    rm -rf ./users
    rm -rf ./index.txt
    rm -rf ./index.txt.old
    rm -rf ./index.txt.attr
    rm -rf ./index.txt.attr.old
    rm -rf ./serial
    rm -rf ./serial.old
}

build(){
	mkdir private
	mkdir server
	mkdir newcerts
    echo -e '开始构建Ca'
	buildCa
	echo -e '开始构建Server'
    buildServer
    echo -e '开始构建Client'
	buildClient
}

case $1 in
start)
    clear
    build
;;
clear)
    clear
;;
*)
    echo "Usage: $0 (start|clear)
        start 构建证书
        clear 清除构建证书产生的资源（所有）文件
        "
;;
esac
