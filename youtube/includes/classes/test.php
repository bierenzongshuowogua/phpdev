<?php
		$duration = (3*60*60)+(54*60)+33;
		//$duration = 184;
		$hours = floor((int)$duration / 3600);
		echo $duration.'/n';
		$mins = floor(((int)$duration / 60) % 60);
		$secs = floor(((int)$duration % 60));
		$hours = ($hours < 10) ? "0".$hours.":" : $hours.":";
		if($hours<1)$hours="";
		$mins = ($mins < 10) ? "0".$mins.":" : $mins.":";
		$secs = ($secs < 10) ? "0".$secs.":" : $secs;
		$duration =  $hours.$mins.$secs;
		echo $duration;
?>
