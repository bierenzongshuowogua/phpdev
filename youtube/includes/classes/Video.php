<?php
class Video{
	private $con, $sqlData, $userLoggedInObj;
	public function __construct($con, $input, $userLoggedInObj) {
		$this->con = $con;
		$this->userLoggedInObj = $userLoggedInObj;
		if(is_array($input)) {
			$this->sqlData = $sqlData;
		}else{
			//根据id查询
			$query = $this->con->prepare("select *from videos where id=:id");
			$query->bindParam(":id", $input);
			$query->execute();
			$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
		}
	}
	//1 获取视频id
	public function getId(){
		//var_dump($this->sqlData);
		return $this->sqlData["id"];	
	}
	//2 获取上传者username
	public function getUploadedBy(){
		return $this->sqlData["uploaded_by"];	
	}
	//3 获取上传视频标题
	public function getTitle(){
		return $this->sqlData["title"];	
	}
	//4 获取上传视频描述
	public function getDescription(){
		return $this->sqlData["description"];	
	}
	//5 获取上传权限
	public function getPrivacy(){
		return $this->sqlData["privacy"];	
	}
	//6 获取上传视频路径
	public function getFilePath(){
		return $this->sqlData["file_path"];	
	}
	//7 获取上传视频分类
	public function getCategory(){
		return $this->sqlData["category"];	
	}
	//8 获取上传视频日期
	public function getUploadDate(){
		return $this->sqlData["upload_date"];	
	}
	//9 获取上传视频浏览次数
	public function getViews(){
		return $this->sqlData["views"];	
	}
	//10 获取上传视频总时长
	public function getDuration(){
		return $this->sqlData["duration"];	
	}

	//11 获取点赞次数
	public function getSupport(){
		return $this->sqlData["support"];
	}
	
	//12 获取踩次数
	public function getDisSupport(){
		return $this->sqlData["notsupport"];
	}
	public function incrementViews(){
		$query = $this->con->prepare("update videos set views=views+1 where id=:id");
		$query->bindParam(":id", $videoId);
		$videoId = $this->getId();
		$query->execute();
	}
	public function incrementSupport(){
		$query = $this->con->prepare("update videos set support=support+1 where id=:id");
		$query->bindParam(":id", $videoId);
		$videoId = $this->getId();
		$query->execute();
	}
	public function incrementDisSupport(){
		$query = $this->con->prepare("update videos set notsupport=notsupport+1 where id=:id");
		$query->bindParam(":id", $videoId);
		$videoId = $this->getId();
		$query->execute();
	}
	public function getVideoValid($id){
		$query = $this->con->prepare("select valid from videos where id=$id");
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		//echo $ret[0]['valid'];
		if($ret[0]['valid'] == 1){
			return false;
		}
		return true;
	}
}

?>
