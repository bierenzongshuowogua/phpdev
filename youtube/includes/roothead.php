<?php
require_once('./includes/config.php');
require_once('./includes/classes/rootUser.php');
$rootuser = new rootUser($con, $_SESSION['rootname']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="./assets/css/rootstyle.css">
	<link rel="stylesheet" href="./assets/iconfont/iconfont.css">
	<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">  
	<link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">    
	<script src="https://unpkg.com/swiper/js/swiper.js"> </script>  
	<script src="https://unpkg.com/swiper/js/swiper.min.js"> </script>

	<title>系统管理</title>
</head>
<body>
	<div id="page-container">
		<div id="head-container">
			<div id="root-name">
				<?php 
					$username = $rootuser->getRootUsername();
					echo "欢迎管理员".$username."!";
				?>
			</div>
			<div id="graduation-design-theme">
				<span>毕业设计后台管理系统</span>
			</div>
			<div id="root-picturepath">
			<?php
				echo $rootuser->getPicturePath();
			?>
			</div>
		</div>
		
		<div id="side-nav-container">
			<div id="add-root">		
				<a href="./addAdministrators.php"><i class="iconfont icon-addrootinfo"></i>添加管理员</a>
			</div>
			<div id="delete-root">
				<a href="./deleteAdministrators.php"><i class="iconfont icon-deleteinfo"></i>删除管理员</a>
			</div>
			<div id="all-root-info">
				<a href="./allUserInfo.php"><i class="iconfont icon-guanliyuanxinxi1"></i>管理员信息</a>
			</div>
			<div id="stop-user-info">
				<a href="./stopUser.php"><i class="iconfont icon-stopuser"></i>封停用户信息</a>
			</div>
			<div id="all-user-info">
				<a href="./allCommonInfo.php"><i class="iconfont icon-userinfo"></i>用户信息</a>
			</div>
			<div id="seal-user">
				<a href="./sealUser.php"><i class="iconfont icon-userinfo"></i>封禁用户</a>
			</div>
			<div id="unseal-user">
				<a href="./unsealUser.php"><i class="iconfont icon-userinfo"></i>解封用户</a>
			</div>
			
		</div>
		<div id="right-container">

