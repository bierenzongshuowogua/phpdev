<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/Constants.php');
	require_once('./includes/classes/Account.php');
	$account = new Account($con);
	if(isset($_POST['seal_button'])) {
		$username = empty($_POST['username'])?"":$_POST['username'];
		$account->unseal($username);
	}
	function getInputValue($username){
		if(isset($_POST['username'])){
			echo $_POST['username'];
		}
	}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title> 解封用户 </title>

</head>
<body>
	<div id="seal-user-container">
		<form action="unsealUser.php" method="POST">
			<?php echo $account->getError(Constants::$USER_UNSEAL_SUCCESS);?>
			<?php echo $account->getError(Constants::$USER_UNSEAL_FAILED);?>
			<input type="text" placeholder="用户名" autocomplete="off" name="username" value="<?php getInputValue('username')?>" require>
			<input type="submit" value="解封" name="seal_button">
		</form>
	</div>
</div>
</div>
</body>


</html>

