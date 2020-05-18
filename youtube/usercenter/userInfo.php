<?php
	require_once('./userCenter.php');
	require_once('./../includes/classes/modifyUserInfo.php');
	require_once('./../includes/classes/Focus.php');
	require_once('./Wallet.php');
	$user = new User($con, $username);
	if(isset($_FILES['picInput'])) {
	//	var_dump($_FILES);
		$mui = new modifyUserInfo($con);
		$mui->modifyPic($username, $_FILES['picInput']);
	}
	$focus = new Focus($con, $username);
	$wallet = new Wallet($con, $username);
	$totalCoins = $wallet->getCoins();
	$focusNum = $focus->getFocus($username);	
	$fansNum = $focus->getFans($username);
?>
	<div class="user-center-right-container-userinfo">
		<h3 class="title">个人资料</h3>
		<div class="user-info">
			<div class="user-info-header">
				<img class="user-picture" src="<?php
					echo $user->getUserPic();
				?>"></img>
		
				<div class="user-info-header-modify">
					<form action='./userInfo.php' method='POST' enctype='multipart/form-data' style="display:none">
						<input type='file' class='user-info-header-modify-form' name='picInput' value="修改头像" required>
						<input type='submit' class="modify-head-button" name='picSubmit' value=修改头像>
					</form>
					<button class="mybuttonchoose">修改头像</button>
					<button class="mybuttonupload" style="display:none">上传</button>
				</div>
				<script>
				$(document).ready(function(){
					$(".mybuttonchoose").click(function(){
						$(".user-info-header-modify-form").click();
						$(".mybuttonchoose").hide();
						$(".mybuttonupload").show();
					});
					$(".mybuttonupload").click(function(){
						$(".modify-head-button").click();
						$(".mybuttonchoose").show();
						$(".mybuttonupload").hide();
					});
					$(".user-info-header-modify-form").change(function(e){
						console.log(e);
						var fileMsg = e.currentTarget.files;
						var fileName = fileMsg[0].name;
						var fileType = fileMsg[0].type;
						console.log(fileMsg[0]);
						var type = (fileType.substr(fileType.lastIndexOf("."))).toLowerCase();
						//alert(fileType);
						if(fileType != "image/png"){
							alert("您上传的图片非image/png");
							return false;
						}
					});
					//var url = "<?php echo $user->getUserPic()?>";
				//	$(".user-info-header-modify-form").("src", "url?timestamp=" + new Date().getTime());
				});
				</script>	
			</div>
			<div class="user-info-detail">
				<ul class="self">
					<li><a href='./viewFocus.php' target='_self' class='view-focus-page'>关注:<?php echo $focusNum;?></a>
					<li><a href='./viewFans.php' target='_self'>粉丝:<?php echo $fansNum;?></a>
					<li>积分 : <?php echo $totalCoins;?></li>
					<li>用户名 : <?php echo $user->getUserName();?></li>
					<li>姓 : <?php echo $user->getFirstName();?></li>
					<li>名 : <?php echo $user->getLastName();?> </li>
					<li>邮箱 : <?php echo $user->getEmail();?> </li>
					<li>注册时间 : <?php echo $user->getSignUpTime();?></li>
					<li>学历 : </li>
					<li>学校 : </li>
					<li>公司 : </li>
					<li>行业 : </li>
				<ul>
				
			</div>
			<script>
				$(document).ready(function(){
				});
			</script>
		</div>
	<div>

