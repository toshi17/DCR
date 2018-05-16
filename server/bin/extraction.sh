#!/bin/bash

exclude='grep -v -e EOS -e 接尾 -e 代名詞 -e 非自立'
exword="grep -v -E '^ー|^一|^二|^三|^四|^五|^六|^七|^八|^九|^十|^百|^千|^万|^億|^兆'"

mecab -F'%M %f[0] %f[1] %pl %f[6]\n'|$exclude|$exword|grep -e 名詞|sed -e 's/ .*//g'
