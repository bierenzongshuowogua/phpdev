<?php
class AllUser{
	private $con;
	private $sqlData;
	public function __construct($con){
		$this->con = $con;
		$query = $this->con->prepare("select *from users");
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		$sqlData = $data;
	}
	public function getAllUser() {
		return $sqlData;
	}
}
?>
