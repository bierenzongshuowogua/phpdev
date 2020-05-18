
<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/rootUserInfo.php');
	if(!isset($_POST['delete_button'])){
		echo 'filed';
	}
	$rootuser = new rootuserInfo($con);
	$username = isset($_POST['username'])?$_POST['username']:"";
	$wasSuccessful = $rootuser->deleteRootUser($username);
	if($wasSuccessful){
		echo "success";
	}else{
		echo "failed";
	}

?>
