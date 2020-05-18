<?php
	require_once('./includes/head.php');
	require_once('./includes/classes/VideoUploadData.php');
	require_once('./includes/classes/VideoProcessor.php');
	require_once('./usercenter/Wallet.php');
	//判断是否通过表单过来的
	
	if(!isset($_POST['uploadButton'])){
		echo 'NOTICE: 禁止使用bug!'.'<br />';
		echo 'NOTICE: FILE NOT CHOOSE!';
		exit();
	}
	//TODO 1)处理基本数据
	//var_dump($_FILES['fileInput']);
	//exit;		
	

	//						$userLoggedInObj->getUserName();
//	var_dump($userLoggedInObj);
	$videoUploadData = new VideoUploadData(
							$_FILES['fileInput'],
							$_POST['titleInput'], 
							$_POST['descriptionInput'], 
							$_POST['privacy'], 	
							$_POST['category'],
							$userLoggedInObj->getUserName()
							);
	
	//TODO 2)上传视频文件
	$videoProcessor = new VideoProcessor($con);
	$wasSuccessful = $videoProcessor->uploadVideo($videoUploadData);
	if($wasSuccessful){
		$username = $userLoggedInObj->getUserName();
		$wallet = new Wallet($con, $username);
		$wallet->addCoins(10);
		echo '上传成功';
	}
	//TODO 3)
?>

