<?php
	$cmd = "ffmpeg -i input.mp4 -vcodec h264 output.mp4";
	$outputLog = array();
	exec($cmd, $outputLog, $returnCode);
	if($returnCode != 0){
		foreach($outputLog as $line ){
			echo $line;
		}
	}
	echo $returnCode;
	var_dump($outputLog);

?>
