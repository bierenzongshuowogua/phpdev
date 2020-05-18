<?php

class modifyUserInfo{
	private $con;
	private $un;
	private $sizeLimit = 500000000;
	public function __construct($con){
		$this->con = $con;	
	}

	public function modifyPic($un, $picData) {
		$targetDir = "../uploads/pictures/";
		$tempPath = $targetDir.uniqid().basename($picData['name']);
		$tempPath = str_replace(" ","_",$tempPath);
		$isValidData = $this->processData($picData, $tempPath);
		if($isValidData == false) {
			return false;
		}
		if(move_uploaded_file($picData['tmp_name'], $tempPath)) {
			$finalPath = $targetDir.uniqid().'.png';
			if(!$this->changeName($tempPath, $finalPath)){
				echo 'shell failes';
				return false;
			}
			/*
			if(!$this->deleteFile($tempPath)){
				return false;
			}*/
			if(!$this->insertPic($un, $finalPath)) {
				echo 'png insert failed';
				return false;
			}
			return true;
		}
		else {
			echo '上传失败';
		}
		return false;
	}
	public function processData($data, $path) {
		if(!$this->isValidSize($data['size'])){
			echo '图片过大';
			return false;
		}else if(!$this->isValidType($data['type'])){
			echo '图片类型错误';
			return false;
		}else if(!$this->hasError($data['error'])){
			echo '上传失败';
			return false;
		}
		return true;
	}
	public function isValidSize($data){
		if($data < $this->sizeLimit )return true;
		return false;
	}
	public function isValidType($data){
		if($data == "image/png")return true;
		return false;	
	}
	public function hasError($data){
		if($data == 0)return true;
		return false;
	}
	public function changename($tp, $fp){
		$cmd = "mv $tp $fp";
		$outputLog = array();
		exec($cmd, $outputLog, $returnCode);
		if($returnCode != 0){
			foreach($outputLog as $line) {
				echo $line.'</br>';
			}
		return false;
		}
		return true;
	}
	private function deleteFile($filePath) {
		if(!unlink($filePath)){
			echo 'delete source png failed';
			return false;
		}
		return true;
	}
	private function insertPic($un, $PicPath){
		//$query = $this->con->prepare("update users set profile_pic=:profile_pic where username=:username");
		$query = $this->con->prepare("update users set profile_pic=:profile_pic where username=:username");
		$query->bindParam(":profile_pic", $PicPath);
		$query->bindParam(":username", $un);
		return $query->execute();

		if($query->rowCount() == 1){
			return true;
		}else{
			echo 123;
			return false;
		}
	}
}

?>
