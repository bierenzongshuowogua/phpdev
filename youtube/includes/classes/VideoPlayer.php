<?php
class VideoPlayer{
	private $video;
	
	public function __construct($video){
		$this->video = $video;
	}
	public function create($autoPlay) {
	//创建播放器
		$autoPlay = $autoPlay ? 'autoPlay' : "";
		$filePath = $this->video->getFilePath();
		//muted='true';
		return "
			<video class='video-player' controls $autoPlay >
				<source src='$filePath' type='video/mp4'></source>
			</video>
			";	
	}
}
?>
