<?php
	require_once('./../includes/config.php');
	require_once('./../includes/classes/User.php');
	if(!isset($_SESSION['userLoggedIn'])){
		header('Location:../signIn.php');
		return ;
	}
	$username = $_SESSION['userLoggedIn'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="./../assets/iconfont/iconfont.css">	
	<link rel="stylesheet" href="./../assets/css/style.css">
	<script src="./../assets/jQuery/jquery-3.3.1.min.js"></script>
</head>
<body>
	<div id="user-center-container">
			<ul class="user-center-container-top-ul">
				<a href="../index.php">首页</a>
				<a href="#">会员</a>
				<a href="#">例子</a>
				<a href="#">例子</a>
				<a href="#">例子</a>
			</ul>
		<div id="user-center-left-container">
			<div id="user-center-left-logo">
				<img src="./../assets/imgs/logo.png" alt="">
			</div>
			<div id="user-center-left-list">
			<ul>
				<li><a href="userInfo.php">个人资料</a></li>
				<li><a href="./myPublish.php">我的发布</a></li>
				<li><a href="./myCollection.php">我的收藏</a></li>
				<li><a href="./myComment.php?">我的评论</a></li>
				<!--<li><a href="./myThumbsUp.php">我的点赞</a></li>-->
				<li><a href="./myWallet.php">我的钱包</a></li>
				<li><a href="./myPassword.php">修改密码</a></li>
				<li><a href="../rootUser.php">管理员入口</a></li>
				<li><a href="./myExit.php?">退出登录</a></li>
			</ul>
			</div>
		</div>
		<div id="user-center-right-container">
