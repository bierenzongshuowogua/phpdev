<?php
class Account{
	private $con;
	private $errorArray = [];
	public function __construct($con){ 
		$this->con = $con;
	}
	
	public function register($fn, $ln, $un, $em, $cf_em, $pw, $cf_pw){
		$this->validataFirstName($fn);	
		$this->validatalastName($ln);	
		$this->validataUserName($un);
		$this->validataEmail($em, $cf_em);
		$this->validataPassword($pw, $cf_pw);
		
		if(empty($this->errorArray)) {
			return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
		}else {
			return false;
		}
	}
	//登陆
	public function login($username, $password) {
		$password = md5($password);
		$query = $this->con->prepare("select *from users where username=:un and password=:pw");
		$query->bindParam(":un", $username);
		$query->bindParam(":pw", $password);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		if($query->rowCount()==1) {
			if($ret[0]['is_stop'] == 1)return false;
			return true;
		}else {
			array_push($this->errorArray, Constants::$LOGINFAILED_ERROR);
			return false;
		}	
		return true;
	}
	//修改密码
	public function modifyPassword($un, $op, $np, $ncp){
		$this->validataPassword($np, $ncp);
		$password=md5($op);
		$query = $this->con->prepare("select * from users where username=:username and password=:password");
		$query->bindParam(":username", $un);
		$query->bindParam(":password", $password);
		$query->execute();
		if($query->rowCount() == 1){
			$newPassword = md5($np);
			$query = $this->con->prepare("update users set password=:password where username=:username");
			$query->bindParam(":password", $newPassword);
			$query->bindParam(":username", $un);
			$query->execute();
			if($query->rowCount()==1){
				return true;
			}else{
				return false;
			}
		}else{
			array_push($this->errorArray, Constants::$ORIGINAL_PASSWORD_ERROR);
			return false;	
		}
	}
	//封禁
	public function seal($username){
		$query = $this->con->prepare("select *from users where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		if($query->rowCount() == 0){
			array_push($this->errorArray, Constants::$USER_NOT_EXIST);
			return false;
		}else if($ret[0]['is_stop'] == 1) {
			array_push($this->errorArray, Constants::$USER_IS_INSEAL);
			return false;
		}else{
			$query = $this->con->prepare("update users set is_stop=1 where username=:username");
			$query->bindParam(":username", $username);
			$query->execute();
			if($query->rowCount()==1){
			array_push($this->errorArray, Constants::$USER_SEAL_SUCCESS);
				return true;
			}else{
				return false;
			}
		}
	}
	//解封
	public function unseal($username) {	
		$query = $this->con->prepare("update users set is_stop=0 where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		if($query->rowCount() == 1){
			array_push($this->errorArray, Constants::$USER_UNSEAL_SUCCESS);
			return true;
		}else {
			array_push($this->errorArray,  Constants::$USER_UNSEAL_FAILED);
			return false;
		}
	}
	private function insertUserDetails($fn, $ln, $un, $em, $pw) {
		$pp = 'assets/profilePicture/default.png';
		//$pw = hash('sha512', $pw);//得到100位的加密字符
		$pw = md5($pw);
		$query = $this->con->prepare("insert into users(
												first_name,
												last_name,
												username,
												email,
												password,
												profile_pic)
										values(
											:fn,
											:ln,
											:un,
											:em,
											:pw,
											:pp
											)		
										");
		$query->bindParam(":fn", $fn);
		$query->bindParam(":ln", $ln);
		$query->bindParam(":un", $un);
		$query->bindParam(":em", $em);
		$query->bindParam(":pw", $pw);
		$query->bindParam(":pp", $pp);
		return $query->execute();
	}
	//名字长度
	private function validataFirstName($fn){
		if(strlen($fn)>25 || strlen($fn)<2) {
			//$this->errorArray['FirstName'] = Constants::$firstNameError;	
			array_push($this->errorArray, Constants::$FIRSTNAME_ERROR);
		}

	}
	
	private function validatalastName($ln){
		if(strlen($ln)>25 || strlen($ln)<2) {
			array_push($this->errorArray, Constants::$LASTNAME_ERROR);
		}
	}
	
	private function validataUserName($un) {
		if(strlen($un)>25 || strlen($un)<2) {
			array_push($this->errorArray, Constants::$USERNAME_LENGTHERROR);
			return ;
		}
		$query = $this->con->prepare("select username from users where username=:un");
		$query->bindParam(":un",$un);
		$query->execute();
		if($query->rowCount() != 0) {
			array_push($this->errorArray, Constants::$USERNAME_REPEATERROR);
		}
	}
	
	private function validataEmail($em, $cf_em) {
		if($em != $cf_em) {
			array_push($this->errorArray, Constants::$EMAIL_DONOTMATCHERROR);
			return ;
		}
		//filter_var函数验证邮箱格式是否正确，不必写正则表达式
		if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Constants::$EMAIL_INVALIDERROR);
			return ;
		}
		
	
		$query = $this->con->prepare("select email from users where email=:em");
		$query->bindParam(":em", $em);
		$query->execute();
		if($query->rowCount() != 0){
			array_push($this->errorArray, Constants::$EMAIL_REPEATERROR);	
			return ;
		}	
	}

	private function validataPassword($pw, $cf_pw) {
		if($pw != $cf_pw) {
			array_push($this->errorArray, Constants::$PASSWORD_DONOTMATCHERROR);
			return ;	
		}
		
		//验证密码复杂度
		/*
		if(preg_match('/[^A-Za-z0-9]/',$pw))) {
			array_push($this->errorArray, Constants::$PASSWORD_FUZADUERROR);
			return ;
		}	
		*/
		if(strlen($pw)>30 || strlen($pw)<5) {
			array_push($this->errorArray, Constants::$PASSWORD_LENGTHERROR);
		}
	}
	public function getError($error){
		if(in_array($error, $this->errorArray)) {
			return "
			<span class='error-message'>$error</span>
			";
		}
	}

	public function dumpErrorInfo() {
		var_dump($this->errorArray);
	}
	
		
	
}

?>
