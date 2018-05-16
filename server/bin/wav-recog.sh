#!/bin/bash

dictation_dir='/home/tohoku-i/dictation-kit'
echo $1 > $1.txt

$dictation_dir/bin/linux/julius -C $dictation_dir/main.jconf -C $dictation_dir/am-gmm.jconf -cutsilence -filelist $1.txt|grep -E '^sentence1:'|sed -e 's/sentence1://g' -e 's/ //g'

rm $1.txt
