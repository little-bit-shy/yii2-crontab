#!/bin/sh  

base="./"  
mkdir -p $base/users/  
openssl genrsa -des3 -out $base/users/client.key 1024  
openssl req -new -key $base/users/client.key -out $base/users/client.csr  
openssl ca -in $base/users/client.csr -cert $base/private/ca.crt -keyfile $base/private/ca.key -out $base/users/client.crt -config "./openssl.conf"  
openssl pkcs12 -export -clcerts -in $base/users/client.crt -inkey $base/users/client.key -out $base/users/client.p12  
