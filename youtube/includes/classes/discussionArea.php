<?php
class discussionArea{
	private $con;
	private $username;
	public function __construct($con) {
		$this->con = $con;
	}
	public function addDiscussion($username, $text) {
		$query = $this->con->prepare("insert into discussion(username,text) values(:username, :text)");
		$query->bindParam(":username", $username);
		$query->bindParam(":text", $text);
		return $query->execute();
	}
	public function getDiscussion() {
		$query = $this->con->prepare("select *from discussion");
		$query->execute();
		$data = $query->fetchall($PDO::FETCH_ASSOC);
		return $data;
	}
}
?>
