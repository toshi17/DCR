#!/bin/bash

exclude='grep -v -e 3 -e EOS -e 接尾 -e 非自立 -e 副詞 -e 代名詞 -e 助詞 -e 記号 -e 助動詞 -e 感動詞'

mecab -F'%M %f[0] %f[1] %pl %f[6]\n'|$exclude|grep -e 名詞|sed -e '/動詞/s/.* .* .* .* //g'|sed -e 's/ .*//g'
