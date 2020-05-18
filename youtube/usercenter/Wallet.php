<?php
class Wallet{
	private $con;
	private $username;
	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;
	}
	private function bigNumChange($number) {
		if($number < 10000){
			return $number;
		}else if($number<100000000){
			return strval($number/10000).'万';
		}else {
			return strval($number/100000000).'亿';
		}
	}
	public function getCoins() {
		$query = $this->con->prepare("select *from wallet where username=:username");
		$query->bindParam(":username", $this->username);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($data)==0) {
			return 0;
		}else {
			$coins = $data[0]['coins'];
			return $this->bigNumChange($coins);
		}
	}
	public function addCoins($coins) {
		$query = $this->con->prepare("select *from wallet where username=:username");
		$query->bindParam(":username",$this->username);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($data)>0) {
			$query = $this->con->prepare("update wallet set coins=coins+:coins where username=:username");
			$query->bindParam(":coins", $coins);
			$query->bindParam(":username", $this->username);
			$query->execute();
			return true;
		}else {
			$query = $this->con->prepare("insert into wallet(coins,username) values(:coins, :username)");
			$query->bindParam(":coins", $coins);
			$query->bindparam(":username", $this->username);
			$query->execute();
			return true;
		}
	}
}

?>
