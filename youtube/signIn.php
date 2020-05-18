<?php
	require_once('./includes/config.php');
	require_once('./includes/classes/Account.php');
	require_once('./includes/classes/FormSanitizer.php');
	require_once('./includes/classes/Constants.php');
	$account = new Account($con);
	if(isset($_POST['submit_button'])) {
		$username = FormSanitizer::sanitizeFormUsername($_POST['username']);
		$password = FormSanitizer::sanitizeFormPassword($_POST['password']);
		$wasSuccessful = $account->login($username, $password);
		
		if($wasSuccessful) {
			//登陆成功
			$_SESSION['userLoggedIn'] = $username;
			header('Location:usercenter/userInfo.php');
		}
	/*
		else {
			echo 'failed';
		}
	*/	
	
	}
	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>用户登陆</title>
	
	<link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/iconfont/iconfont.css">	
	<link rel="stylesheet" href="./assets/css/style.css">
	
	<script src="./assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="./assets/bootstrap/popper.min.js"></script>
	<script src="./assets/bootstrap/bootstrap.min.js"></script>
	<script src="./assets/js/common-action.js"></script>
</head>
<body>
	<div class="sign-up-container">
		<div class="column">
			<div class="header">
				<img src="assets/imgs/logo.png" alt="">
				<h3>登陆</h3>
				<span>欢迎登陆本站</span>
			</div>
			
			<div class="sign-up-form">
				<form action="signIn.php" method="POST">
					<?php echo $account->getError(Constants::$LOGINFAILED_ERROR);?>
					<input type="text" placeholder="用户名" name="username" autocomplete="off" value = "<?php getInputValue('username')?>"require>
					<input type="password" placeholder="密码" name="password" autocomplete="off" value="<?php getInputValue('password')?>" require>
					<input type="submit" name="submit_button" value="登陆">
				</form>	
			</div>
			
			<a class="sign-in-message" href="signUp.php">还没有账号？点此注册</a>
		</div>	
	</div>
</body>
</html>
