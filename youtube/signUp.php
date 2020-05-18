<?php 
	require_once('./includes/config.php');
	require_once('./includes/classes/FormSanitizer.php');
	require_once('./includes/classes/Account.php');
	require_once('./includes/classes/Constants.php');
	$account = new Account($con);
	//var_dump($_POST);
	if(isset($_POST['submit_button'])){
		$firstName = FormSanitizer::sanitizeFormString($_POST['first_name']);
		$lastName = FormSanitizer::sanitizeFormString($_POST['last_name']);
		$username = FormSanitizer::sanitizeFormUsername($_POST['username']);
		$email = FormSanitizer::sanitizeFormEmail($_POST['email']);
		$confirmEmail = FormSanitizer::sanitizeFormEmail($_POST['confirm_email']);
		$password = FormSanitizer::sanitizeFormPassword($_POST['password']);
		$confirmPassword = FormSanitizer::sanitizeFormPassword($_POST['confirm_password']);
		/*
		echo $firstName.'<br />';
		echo $username.'<br />';
		echo $email.'<br />';
		echo $confirmEmail.'<br />';
		echo $password.'<br />';
		echo $confirmPassword.'<br />';
		die;
		*/
		$wasSuccessful = $account->register(
						$firstName,
						$lastName,
						$username,
						$email,
						$confirmEmail,
						$password,
						$confirmPassword
					);
		//$account->dumpErrorInfo();
		//TODO 注册用户
		if($wasSuccessful) {
			//跳转到主页
			$_SESSION['userLoggedIn'] = $username;
			header('Location:index.php');	
		}else {
			echo 'failed';
		}
	}
	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];;
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UFT-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>用户注册</title>
	
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
				<h3>注册</h3>
				<span>你还没有账号吗？</span>
			</div>
			
			<div class="sign-up-form">
				<form action="signUp.php" method="post">
					<?php echo $account->getError(Constants::$FIRSTNAME_ERROR);?>
					<input type="text" placeholder="姓" name="first_name" autocomplete="off" value="<?php getInputValue('first_name');?>"require>
	
					<?php echo $account->getError(Constants::$LASTNAME_ERROR);?>
					<input type="text" placeholder="名" name="last_name" autocomplete="off" value= "<?php getInputValue('last_name');?>" require>

					<?php echo $account->getError(Constants::$USERNAME_LENGTHERROR);?>
					<?php echo $account->getError(Constants::$USERNAME_REPEATERROR);?>
					<input type="text" placeholder="用户名" name="username" autocomplete="off" value="<?php getInputValue('username')?>";require>
					<?php echo $account->getError(Constants::$EMAIL_DONOTMATCHERROR);?>
					<?php echo $account->getError(Constants::$EMAIL_INVALIDERROR);?>
					<?php echo $account->getError(Constants::$EMAIL_REPEATERROR);?>
					<!--<input type="email" placeholder="邮箱" name="email" autocomplete="off" value="<?php getInputValue('email')?>" require> -->
					<input type="text" placeholder="邮箱" name="email" autocomplete="off" value="<?php getInputValue('email')?>" require>
					<!--<input type="email" placeholder="确认邮箱" name="confirm_email" autocomplete="off" value="<?php getInputValue('confirm_email');?>" require> -->
					<input type="text" placeholder="确认邮箱" name="confirm_email" autocomplete="off" value="<?php getInputValue('confirm_email');?>" require>
					<?php echo $account->getError(Constants::$PASSWORD_LENGTHERROR);?>
					<?php echo $account->getError(Constants::$PASSWORD_DONOTMATCHERROR);?>
					<input type="password" placeholder="密码" name="password" autocomplete="off" value="<?php getInputValue('password')?>" require>
					<input type="password" placeholder="确认密码" name="confirm_password" autocomplete="off" value="<?php getInputValue('confirm_password')?>"require>
					<input type="submit" name="submit_button" value="注册">
				</form>	
			</div>
			
			<a class="sign-in-message" href="signIn.php">已经有账号？点此登陆</a>
		</div>	
	</div>
</body>
</html>
