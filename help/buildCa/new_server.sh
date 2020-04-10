#!/bin/sh  

buildServer(){
	openssl genrsa -out server/server.key  
	openssl req -new -key server/server.key -out server/server.csr  
	openssl ca -in server/server.csr -cert private/ca.crt -keyfile private/ca.key -out server/server.crt -config "./openssl.conf"
}