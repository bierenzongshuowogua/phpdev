<?php
class Collection{
	private $con;
	private $username;
	public function __construct($con,$username) {
		$this->con = $con;
		$this->username = $username;
	}
	//添加收藏
	public function addCollection($videoId){ 
		//查看是否收藏
		$query = $this->con->prepare("select *from collection where username=:username and video_id=:video_id");
		$query->bindParam(":username",$this->username);
		$query->bindParam(":video_id",$videoId);
		$query->execute();
		
		if($query->rowCount()>0){
			//收藏过直接返回
			return true;
		}else {
			//没有收藏过插入收藏表
			$query = $this->con->prepare("insert into collection(username,video_id) values(:username,:video_id)");
			$query->bindParam(":username", $this->username);
			$query->bindParam(":video_id", $videoId);
			return $query->execute();
		}
	}
}
?>
