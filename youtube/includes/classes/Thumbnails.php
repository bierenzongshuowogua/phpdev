<?php
class Thumbnails{
	private $con, $sqlDta;
	public function __construct($con) {
		$this->con = $con;
		$query = $this->con->prepare("select *from thumbnails where selected=1");
		$query->execute();
		$this->sqlData = $query->fetchall(PDO::FETCH_ASSOC);
	}
	public function getThumbnails(){
		//return array_column($this->sqlData,'file_path');
		//var_dump($this->sqlData);
		return $this->sqlData;
	}

}

?>
