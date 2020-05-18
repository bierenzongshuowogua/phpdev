<?php
require_once('./includes/config.php');
require_once('./includes/classes/FormSanitizer.php');
require_once('./includes/classes/rootAccount.php');
require_once('./includes/classes/Constants.php');
$rootaccount = new rootAccount($con);
if(isset($_POST['rootsubmitbutton'])){
	$username = FormSanitizer::sanitizeFormUsername($_POST['rootname']);
	$password = FormSanitizer::sanitizeFormPassword($_POST['rootpassword']);
	$wasSuccessful = $rootaccount->rootLogin($username, $password);
	if($wasSuccessful) {
		$_SESSION['rootname'] = $username;
		//var_dump($_SESSION);
		header('Location:systemManage.php');
	}
	/*
	else {
		echo 'failed';
	}
	*/
}
function getInputValue($name) {
	if(isset($_POST[$name])){
		echo $_POST[$name];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UFT-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>系统管理</title>
	<!--
	<link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css"a>
	<link rel="stylesheet" href="./assets/iconfont/iconfont.css">	-->
	<link rel="stylesheet" href="./assets/css/rootstyle.css">
	<!--
	<script src="./assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="./assets/bootstrap/popper.min.js"></script>
	<script src="./assets/bootstrap/bootstrap.min.js"></script>
	<script src="./assets/js/common-action.js"></script>
	-->
</head>
<body>
	<div class="rootuser-signin-container">
		<div class="column">
			<div class="header">
				<img src="assets/imgs/logo.png" alt=""/>
				<h3> 登陆 </h3>
				<span>欢迎系统管理员登陆</span>
			</div>
			<div class="signin-form">
				<form action="rootUser.php" method="POST">
				<?php echo $rootaccount->getError(Constants::$LOGINFAILED_ERROR);?>
					<input type='text' name="rootname" placeholder="系统用户名" value ="<?php getInputValue('rootname')?>" require>
					<input type='text' name="rootpassword" placeholder="密码" require>
					<input type='submit' name="rootsubmitbutton" value='登陆'>
				</form>
			</div>
		</div>
	</div>



</body>
