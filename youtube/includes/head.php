<?php 
require_once('./includes/config.php');
require_once('./includes/classes/User.php');
require_once('./includes/classes/VideoPlayer.php');
$usernameLoginIn = isset($_SESSION['userLoggedIn']) ? $_SESSION['userLoggedIn'] : "";
$userLoggedInObj = new User($con, $usernameLoginIn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" href="./assets/imgs/favicon.ico" type="image/x-icon">	
	<title>豆芽视频赵猛毕业设计</title>
	
<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="./assets/iconfont/iconfont.css">	

	<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">  
	<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">    
	<script src="https://unpkg.com/swiper/js/swiper.js"> </script>  
	<script src="https://unpkg.com/swiper/js/swiper.min.js"> </script>

	<link rel="stylesheet" href="./assets/css/style.css">

	<!--<script src="./assets/bootstrap/popper.min.js"></script>-->

	<script src="./assets/jQuery/jquery-3.3.1.min.js"></script>
	<script src="./assets/bootstrap/popper.min.js"></script>
	<script src="./assets/bootstrap/bootstrap.min.js"></script>
	<script src="./assets/js/common-action.js"></script>
</head>
<body>
	<div id="page-container">
		<div id="master-head-container">
			<button class="nav-show-hide"><i class="iconfont icon-guide"></i></button>
			<a href="/index.php" class="logo-container"><img src="./assets/imgs/logo.png" class="img-circle" alt=""></a>

			<div id="search-container">
				<form action="./search.php" mothod="GET">
				<input type="text" name="keywords" placeholder="搜索">
				<button><i class="iconfont icon-search"></i></button>
				</form>
			</div>

			<div class="right-icons">
				<a href="./upload.php"><i class="iconfont icon-upload"></i></a>
				<a href="./../usercenter/userInfo.php"><i class="iconfont icon-user_center"></i></a>
			<!--<a href="./../usercenter/userInfo.php" class="btn " role="button">登陆</a>-->
			</div>
	  </div>
	

	<div id="side-nav-container">
		<ul>
		<li><a href="./index.php"><i class="iconfont icon-home"></i>首页</a></li>
		<li><a href="./recomment.php"><i class="iconfont icon-fire"></i>推荐视频</a></li>
		<li><a href="./subscribe.php"><i class="iconfont icon-subscribe"></i>订阅视频</a></li>
		<li><a href="./acient.php"><i class="iconfont icon-acient"></i>古装</a></li>
		<li><a href="./movie.php"><i class="iconfont icon-movie"></i>电影</a></li>
		<li><a href="./music.php"><i class="iconfont icon-music"></i>音乐</a></li>
		<li><a href="./sport.php"><i class="iconfont icon-sport"></i>运动</a></li>
		<!--<li><a href="./discussion.php"><i class="iconfont icon-sport"></i>讨论区</a></li>-->
		</ul>
 <!-- 
<ul class="nav nav-pills nav-stacked">
		<li><a href="./index.php"><i class="iconfont icon-home"></i>首页</a></li>
		<li><a href="./recomment.php"><i class="iconfont icon-fire"></i>推荐视频</a></li>
		<li><a href="./subscribe.php"><i class="iconfont icon-subscribe"></i>订阅视频</a></li>
		<li><a href="./acient.php"><i class="iconfont icon-acient"></i>古装</a></li>
		<li><a href="./movie.php?"><i class="iconfont icon-movie"></i>电影</a></li>
		<li><a href="./music.php?"><i class="iconfont icon-music"></i>音乐</a></li>
		<li><a href="./sport.php?"><i class="iconfont icon-sport"></i>运动</a></li>
</ul>-->
	</div>

	<div id="main-section-container" class="paddingleft">
	<div id="main-content-container">
