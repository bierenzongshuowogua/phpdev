<?php 
	require_once('./userCenter.php');
	require_once('./Wallet.php');
	$username = $_SESSION['userLoggedIn'];
	$wallet = new Wallet($con, $username);
	$coins = $wallet->getCoins();
?>
<div>	
	积分余额：<?php echo $coins;?>
</div>
	抽奖区
