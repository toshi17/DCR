<?php

function recog($file){
	exec("sh /home/tohoku-i/TH_1607/server/bin/wav-recog.sh $file|/home/tohoku-i/TH_1607/server/bin/extraction.sh 2>&1",$out,$ret);
	// exec("sh /home/tohoku-i/TH_1607/server/bin/wav-recog.sh $file",$out,$ret);
	return $out;
}

function recog_n($file){
	exec("sh /home/tohoku-i/TH_1607/server/bin/wav-recog.sh $file|/home/tohoku-i/TH_1607/server/bin/exnoun.sh 2>&1",$out,$ret);
	return $out;
}
?>
