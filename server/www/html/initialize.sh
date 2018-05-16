#!/bin/bash

serv_home=/home/tohoku-i/www/html

rm -f $serv_home/tmp/*
rm -f $serv_home/data.json
cp -p $serv_home/skel.json $serv_home/data.json
echo '{}' > $serv_home/key.json
