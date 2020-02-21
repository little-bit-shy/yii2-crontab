#!/bin/sh  
openssl genrsa -out private/ca.key  
openssl req -new -key private/ca.key -out private/ca.csr  
openssl x509 -req -days 365 -in private/ca.csr -signkey private/ca.key -out private/ca.crt  
echo FACE > serial  
touch index.txt  
openssl ca -gencrl -out private/ca.crl -crldays 7 -config "./openssl.conf"
