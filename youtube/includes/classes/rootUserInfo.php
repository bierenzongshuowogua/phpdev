<?php
class rootUserInfo{
	private $con;
	private $userInfoArr;
	public function __construct($con) {
		$this->con = $con;
	}
	public function getAllUserInfo($offset, $limit) {
		$query = $this->con->prepare("select id,username,add_username,add_time from rootusers limit $limit offset $offset");
		//$query = $this->con->prepare("select *from rootusers where id>:offset limit :$limit");
		//$query->bindParam(":offset", $offset);
		//$query->bindParam(":limit", $limit);
		$query->execute();
		$this->userInfoArr = $query->fetchall(PDO::FETCH_ASSOC);
		return $this->userInfoArr;
	}
	public function deleteRootUser($username) {
		$query = $this->con->prepare("delete from rootusers where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		if($query->rowCount() == 1)	
			return true;
		return false;
	}
	public function getCounts(){
		$sql = "select count(*) from rootusers";
		$ret = $this->con->query($sql);
		$data = $ret->fetchall();
		return $data[0][0];
	}

}

?>
