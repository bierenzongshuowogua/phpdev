<?php
class VideoDetailsFormProvider{
	private $con;
	public function __construct($con){
		$this->con = $con;
	}
	public function createUploadForm(){
		$fileInput = $this->createFileInput();
		$titleInput = $this->createTitleInput();
		$descriptionInput = $this->createDescriptionInput();
		$privacyInput = $this->createPrivacyInput();
		$categoriesInput = $this->createCategoriesInput();
		$uploadButton = $this->createUploadButton();
		return "
		<form action='./processing.php' method='POST' enctype='multipart/form-data'>
			$fileInput
			$titleInput
			$descriptionInput
			$privacyInput
			$categoriesInput		
			$uploadButton
		</form>
		";
	}	
	private function createFileInput(){
		//引入bootstrap表单样式
		return "
			<div class='form-group'>
			<input type='file' class='form-control-file' name='fileInput' required>
			</div>
		";

	}
	
	private function createTitleInput(){
		return "
			<div class='form-group'>
				<input type='text' class='form-control' placeholder='填入标题' name='titleInput' required>
			</div>
		";
	}
	private function createDescriptionInput(){
		return "
			<div class='form-group'>
				<textarea class='form-control' placeholder='填入描述' name='descriptionInput' row='3'></textarea>
			</div>
		";
	}
	private function createPrivacyInput(){
		return "
		<div class='form-group'>
			<select class='form-control' name='privacy'>
				<option value='1'>公开</option>
				<option value='0'>隐私</option>
			</select>
		</div>
		";
	}

	private function createCategoriesInput(){
		$query = $this->con->prepare("SELECT * FROM youtube");
		$query->execute();
		$html = "<div class='form-group'><select name='category' class='form-control'>";
		while($row = $query->fetch(PDO::FETCH_ASSOC)){//索引关联的id->name样式
			$name = $row['name'];
			$id = $row['id'];
			$html.= "<option value='$id'>$name</option>";
		}
		$html .= "</select></div>";
		return $html;
	}
	private function createUploadButton(){
		return "
			<button type='submit' class='btn btn-primary' name='uploadButton'>上传</button>
		";

	}
}
	

?>
