<?php
	require_once('./userCenter.php');
	require_once('./../includes/classes/Account.php');
	require_once('./../includes/classes/Constants.php');
	$account = new Account($con);
	if(isset($_POST['password-modify-submit'])){
		$originalPassword = $_POST['originalPassword'];
		$newPassword = $_POST['newPassword'];
		$newConfirmPassword = $_POST['newConfirmPassword'];
		$username = $_SESSION['userLoggedIn'];
		$wasSuccessful = $account->modifyPassword($username, $originalPassword, $newPassword, $newConfirmPassword);
		if($wasSuccessful){
			echo "修改成功";
		}
		
	}
?>
<div class="user-center-password-modify">
	<form action="myPassword.php" method="POST">
		<?php echo $account->getError(Constants::$ORIGINAL_PASSWORD_ERROR);?>
		<input type="password" name="originalPassword" placeholder="原始密码" autocomplete="off" require>
		<?php echo $account->getError(Constants::$PASSWORD_LENGTHERROR);?>
		<input type="password" name="newPassword" placeholder="输入密码" autocomplete="off" require>
		<?php echo $account->getError(Constants::$PASSWORD_DONOTMATCHERROR);?>
		<input type="password" name="newConfirmPassword" placeholder="确认密码" autocomplete="off" require>
		<input type="submit" name="password-modify-submit" value="修改">
</div>
