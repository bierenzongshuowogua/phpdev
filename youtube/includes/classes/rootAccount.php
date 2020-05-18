<?php
class rootAccount{
	private $con;
	private $errorArray=[];
	public function __construct($con) {
		$this->con = $con;
	}
	public function rootLogin($username, $password) {
		$query = $this->con->prepare("select * from rootusers where username=:username and password=:password");
		$query->bindParam(":username", $username);
		$query->bindParam(":password", $password);
		$query->execute();
		if($query->rowCount()==1) {
			return true;
		}else{
			array_push($this->errorArray, Constants::$LOGINFAILED_ERROR);
			return false;
		}
	}
	public function rootAdd($username,$password,$adduser){
		if($this->isExist($username))
		{
			$query = $this->con->prepare("insert into rootusers(username,password,add_username) values(:username,:password,:adduser)");
			$query->bindParam(":username", $username);
			$query->bindParam(":password", $password);
			$query->bindParam(":adduser", $adduser);
			$query->execute();
			if($query->rowCount()==1){
				return true;
			}else{
				return false;
			}
		}else {
			array_push($this->errorArray, Constants::$USERNAME_REPEATERROR);
		}
	}
	
	public function validataUserName($un) {
		if(strlen($un)>25 || strlen($un)<2) {
			array_push($this->errorArray, Constants::$USERNAME_LENGTHERROR);
		}
		return ;
	}
	public function isExist($un) {
		$query = $this->con->prepare("select *from rootusers where username=:username");
		$query->bindParam(":username", $un);
		$query->execute();
		if($query->rowCount()){
			return false;
		}
		return true;
	}
	public function getError($error) {
		if(in_array($error, $this->errorArray)) {
			return "
			<span class='error-messge'>$error</span>
			";
			
		}
	}
}

?>
