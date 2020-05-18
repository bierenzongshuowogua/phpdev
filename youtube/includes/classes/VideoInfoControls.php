<?php
	require_once('includes/classes/ButtonProvider.php');
class VideoInfoControls{
	private $video, $userLoggedInObj;
	public function __construct($video, $userLoggedInObj) {
		$this->video = $video;
		$this->userLoggedInObj = $userLoggedInObj;
	}	
	public function create(){
		$present = $this->createPresent();
		$likeButton = $this->createLikeButton();
		$dislikebutton = $this->createDisLikeButton();
		$subscribe = $this->createSubscribe();
		return "
			<div class='like-dislike-button'>
				$present
				$likeButton
				$dislikebutton
				$subscribe
			</div>
		";
	}
	private function createSubscribe() {
		$class='my-collection';
		$icon='collection';
		
		return ButtonProvider::createButton('','','',$class,$icon);
	}
	private function createPresent() {
		$class = 'my-gift';
		$icon = 'mygift';
		$action = "giveGift(this)";
		return ButtonProvider::createButton('','',$action,$class,$icon);

	}
	private function createLikeButton() {
	/*
		return "
			<button>like</button>
			";
	*/	
		$text = $this->video->getSupport();
		$videoId = $this->video->getId();
		$action = "likeVideo(this, $videoId)";
		$class = 'like-button';
		$imgSrc = 'assets/imgs/support.png';
		return ButtonProvider::createButton($text, $imgSrc, $action, $class);
	}
	
	private function createDisLikeButton() {
	/*
		return "
			<button>Dislike</button>
			";
	*/
		$text = $this->video->getDisSupport();
		$videoId = $this->video->getId();
		$action = "dislikeVideo(this, $videoId)";
		//$action = "dislikeVideo()";
		$class = 'dislike-button';
		$imgSrc = 'assets/imgs/zhongzhi.png';
		return ButtonProvider::createButton($text, $imgSrc, $action, $class);
	}
	private function likeVideo($videoId){
		echo 123;
	}
	private function createComment() {

	}
	private function createCollect() {

	}

}

?>
