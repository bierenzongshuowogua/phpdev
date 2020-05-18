<?php
class CommonUserInfo{
	private $con;
	private $userInfoArr;
	public function __construct($con) {
		$this->con = $con;
	}
	public function getAllCommonInfo($offset, $limit){
		$query = $this->con->prepare("select id, username,first_name,last_name,email,sign_up_time,is_stop from users limit $limit offset $offset");
		$query->execute();
		$this->userInfoArr = $query->fetchall(PDO::FETCH_ASSOC);
		return $this->userInfoArr;
	}
	public function getCounts(){
		$sql = "select count(*) from users";
		$ret = $this->con->query($sql);
		$data = $ret->fetchall();
		return $data[0][0];
	}
	public function getStopCommonInfo($offset, $limit){
		$query = $this->con->prepare("select id,username,first_name,last_name,email,sign_up_time,is_stop from users where is_stop=1 limit $limit offset $offset");
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		return $ret;
	}
	public function getStopCounts(){
		$sql = "select count(*) from users where is_stop=1";
		$ret = $this->con->query($sql);
		$data = $ret->fetchall();
		return $data[0][0];
	}
}
