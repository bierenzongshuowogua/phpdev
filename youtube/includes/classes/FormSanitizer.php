<?php
class FormSanitizer{

	//用户名校验
	public static function sanitizeFormString($inputText){
		$inputText = strip_tags($inputText);//处理字符串中的标签
		$inputText = str_replace(" ","" ,$inputText);//删除前面后面空格
		$inputText = strtolower($inputText);
		$inputText = ucfirst($inputText);//首字母大写
		return $inputText;
	}	
	
	public static function sanitizeFormUsername($inputText){
		$inputText = strip_tags($inputText);//处理字符串中的标签
		$inputText = str_replace(" ","" ,$inputText);//删除前面后面空格
		return $inputText;
	}	
	
	public static function sanitizeFormEmail($inputText){
		$inputText = strip_tags($inputText);//处理字符串中的标签
		$inputText = str_replace(" ","" ,$inputText);//删除前面后面空格
		return $inputText;
	}	
	
	public static function sanitizeFormPassword($inputText){
		$inputText = strip_tags($inputText);//处理字符串中的标签
		return $inputText;
	}	
}

?>
