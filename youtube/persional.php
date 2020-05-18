<?php
	require_once('./includes/config.php');
	require_once('./includes/classes/User.php');
	require_once('./includes/classes/Focus.php');
	if(!isset($_SESSION['userLoggedIn'])){
		header("Location:signIn.php");
	}
	$userLoggedIn = $_SESSION['userLoggedIn'];
	if(isset($_GET['username']) && isset($_GET['focusname'])){
		$focus = new Focus($con, $userLoggedIn);	
		$focus->addFocus($_GET['focusname']);
		die;
	}
	if(isset($_GET['name']) && isset($_GET['delfocus'])) {
		$focus = new Focus($con, $userLoggedIn);
		$focus->delFocus($_GET['delfocus']);
		die;
	}
	//echo $userLoggedIn;
	if(isset($_GET['name'])) {
		
		$name =  $_GET['name'];
		$self_name = $userLoggedIn;
		if($name == $self_name)
			header("Location:./usercenter/userInfo.php");
		$focus = new Focus($con, $self_name);
		$focusNum = $focus->getFocus($name);
		$fansNum = $focus->getFans($name);
//	echo $name;
		$user = new User($con,$name);
		$user_pic = $user->getUserPic();
		$real_name = $user->getName();
		$email = $user->getEmail();
		$signup_time = $user->getSignUpTime();
	}
//	echo $user_pic;
//	echo 123;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" href="./assets/imgs/favicon.ico" type="image/x-icon">	
	<!--<script rel="stylesheet" href="./assets/css/style.css"></script>-->
	<link rel="stylesheet" href="./assets/css/style.css">
	<script src="./assets/jQuery/jquery-3.3.1.min.js"></script>
	<title>豆芽视频赵猛毕业设计</title>
</head>

<body>
	<div class="persional-page">
	<div class="persional-head">
		<a href="index.php" class="logo-container"><img src="./assets/imgs/logo.png"></a>
		<div class="persional-title">
		<h4><?php echo $name."的主页";?></h4>
		</div>
	</div>
	<div class="persional-side">
	
	</div>
	<div class="persional-container">
		<div class="persional-info">
			<div class="persional-info-head">
				<img src="<?php echo $user_pic?>">
				
				<button class="focus_button"><?php echo $focus->isFocus($name);?></button>
			</div>
			<div class="persional-info-detail">
				<div class="focus-fans">
				<a href="#" class="persional-fans">粉丝:<?php echo $fansNum;?></a>
				<a href="#" class="persional-focus">关注:<?php echo $focusNum;?></a>
				</div>
				<ul>
					<li><?php echo '姓名: '.$real_name;?></li>
					<li>个人简介: </li>				
					<li>生日: </li>				
					<li><?php echo '邮箱: '.$email;?></li>
					<li>手机: </li>				
					<li>职业: </li>				
					<li>年龄: </li>				
					<li><?php echo '注册时间: '.$signup_time;?></li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<script>
		$(document).ready(function(){
			$(".focus_button").click(function(){
				var buttontext = $(".focus_button").text();
				if(buttontext != '取消关注') {
				var username = "<?php echo $userLoggedIn?>";
				//console.log(username);
				var focusname = "<?php echo $name?>";
				//console.log(focusname);
				$.get("persional.php",{username:username,focusname:focusname},function(){
					alert('关注成功');
				//	console.log(buttontext);
					var fansNum = $(".persional-fans").html();
					console.log(fansNum.length);
					var index = fansNum.indexOf(":");
					console.log(index);
					fansNum = Number(fansNum.slice(index+1,fansNum.length))+1;
					console.log(fansNum);
					var add = '粉丝:'+fansNum;
					$(".persional-fans").html(add);
					$(".focus_button").text('取消关注');
				});
			}else{
				$(".focus_button").text('关注');
				
				var fansNum = $(".persional-fans").html();
				var index = fansNum.indexOf(":");
				fansNum = Number(fansNum.slice(index+1,fansNum.length))-1;
				var add = '粉丝:'+fansNum;
				$(".persional-fans").html(add);
				var name = "<?php echo $userLoggedIn;?>";
				var delfocus = "<?php echo $name;?>";
				$.get("persional.php",{name:name,delfocus:delfocus},function(){
					alert("取消关注成功");
				});
			}
			});
		});
	</script>	
</body>

</html>
