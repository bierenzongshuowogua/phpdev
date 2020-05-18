<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/rootAccount.php');
	require_once('./includes/classes/Constants.php');
	$rootaccount = new rootAccount($con);
	if(isset($_POST['submit_button'])){
		$username = ($_POST['username']);
		$password = ($_POST['password']);
		$addname = $_SESSION['rootname'];

		$wasSuccessful = $rootaccount->rootAdd($username, $password, $addname);
		if($wasSuccessful){
			echo "添加成功";
		}else{
			echo "添加失败";
			}
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
	<title>添加管理员</title>

</head>
<body>
	<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">Slide 1</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
    </div>
    <!-- 如果需要分页器 -->
<!--    <div class="swiper-pagination"></div>-->
    
    <!-- 如果需要导航按钮 -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    
    <!-- 如果需要滚动条 -->
<!--    <div class="swiper-scrollbar"></div>-->
<!--
</div>
	<div id="add-rootuser-form">
	<form action="addAdministrators.php" method="POST">
	<?php $rootaccount->getError(Constants::$USERNAME_LENGTHERROR);?>
	<?php $rootaccount->getError(Constants::$USERNAME_REPEATERROR);?>
	<input type="text" name="username" placeholder="用户名" value="<?php getInputValue('username') ?>" require>
	<input type="text" name="password" placeholder="密码" value="<?php getInputValue('password')?>" require>
	<input type="submit" name="submit_button" value="添加">
	</form>
	</div>
	</div>
</div>
-->
</body>
<script>        
  var mySwiper = new Swiper ('.swiper-container', {
    direction: 'vertical', // 垂直切换选项
    loop: true, // 循环模式选项
    
    // 如果需要分页器
    pagination: {
      el: '.swiper-pagination',
    },
    
    // 如果需要前进后退按钮
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    
    // 如果需要滚动条
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  })        
  </script>
</body>
</html>
