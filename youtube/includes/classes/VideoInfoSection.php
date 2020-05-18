<?php
require_once('includes/classes/VideoInfoControls.php');
class VideoInfoSection{
	private $con, $video, $userLoggedInObj;
	public function __construct($con, $video, $userLoggedInobj) {
		$this->con = $con;	
		$this->video = $video;
		$this->userLoggedInObj;
	}
	public function create() {
		return $this->getVideoInfo().$this->getUserInfo();
	}
	private function getVideoInfo() {
		$title = $this->video->getTitle();
		$views = $this->video->getViews();
		$uploaded_by = $this->video->getUploadedBy();
		$viewb = $this->changeNumToBig($views);
		$videoInfoControls = new VideoInfoControls(
								$this->video,
								$this->userLoggedInObj
								);
		//点赞
		//浏览次数
		$controls = $videoInfoControls->create();
		
		return "
			<div class='video-info'>
				<span>$title</span>
				<div class='bottom-section'>
					<p class='view-count'><span>$viewb<span></p>
					$controls
				</div>
			</div>
		";
	}
	private function getUserInfo() {
		return '';
	}
	private function changeNumToBig($num) {
		$ret = '';
		if($num < 100)return $num.'次播放'; 
		if($num > 10000) {
			$num = $num/10000;
			$ret .= $num.'亿次播放';
		}
		else if($num>100) {
			$num = $num/100;
			$ret .= $num.'万次播放';
		
		}
		return $ret;
	}
}

?>
