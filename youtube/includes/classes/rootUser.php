<?php
class rootUser{
	private $con;
	private $sqlData;
	public function __construct($con, $username){
		$this->con = $con;	
		$query = $this->con->prepare("select *from rootusers where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);	
	}
	public function getRootUsername(){
		return $this->sqlData['username'];
	}
	public function getAddUsername(){
		return $this->sqlData['add_username'];
	}
	public function getAddTime(){
		return $this->sqlData['add_time'];
	}
	public function getPicturePath(){
		$picturepath = $this->sqlData['picture_path'];
		return "<img class='picturepath'
					src='$picturepath' 
					alt=''> 
				</img>
			";
	}
}
