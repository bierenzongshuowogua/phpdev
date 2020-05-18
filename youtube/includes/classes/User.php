<?php
class User{
	private $con;
	private $sqlData;
	public function __construct($con, $username){
		$this->con = $con;
		$query = $this->con->prepare("select *from users where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
	}
	public function getUserPic() {
		return $this->sqlData['profile_pic'];
	}
	public function getUserName() {
		return $this->sqlData['username'];
	}
	public function getName() {
		return $this->sqlData['first_name'].$this->sqlData['last_name'];
	}
	public function getFirstName() {
		return $this->sqlData['first_name'];
	}
	public function getLastName() {
		return $this->sqlData['last_name'];
	}
	public function getEmail() {
		return $this->sqlData['email'];
	}
	public function getSignUpTime() {
		return $this->sqlData['sign_up_time'];
	}
	public function getIsStop() {
		return $this->sqlData['is_stop'];
	}
}

?>
