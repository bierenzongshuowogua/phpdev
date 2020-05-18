<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/rootAccount.php');
	if(!isset($_POST['submit_button'])){
		echo 'filed';
	}
	$rootaccount = new rootAccount($con);
	$username = isset($_POST['username'])?$_POST['username']:"";
	$password = isset($_POST['password'])?$_POST['password']:"";
	$addname = $_SESSION['rootname'];
	$wasSuccessful = $rootaccount->rootAdd($username, $password, $addname);
	if($wasSuccessful){
		echo "success";
	}else{
		echo "failed";
	}

?>
