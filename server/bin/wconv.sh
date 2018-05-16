#!/bin/bash

if [ $# -ne 2 ]; then
  exit 1
fi

sox -t raw -e signed-integer -x -b 16 -c 1 -r 8000 $1 -r 16000 -c 1 -b 16 $2
