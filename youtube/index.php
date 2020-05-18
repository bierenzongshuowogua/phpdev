<?php 
require_once('./includes/head.php');
require_once('./mainPage.php');
require_once('./includes/classes/Thumbnails.php');
?>
	<?php
		if(isset($_SESSION['userLoggedIn'])) {
			//echo $userLoggedInObj->getUserName().'</br>';
		/*	echo $userLoggedInObj->getName();
			echo $userLoggedInObj->getEmail();
		*/	
			
		}
		$videos = new mainPage($con);
		//$limit = 20;
		//$offset = 0;
		$pageSize =  25;
		$pageNum = isset($_GET['pageNum'])?$_GET['pageNum']:1;
	//	echo $pageNum;
		$limit = $pageSize;
		$offset = ($pageNum-1)*$pageSize;
		$num = $videos->getVideoCounts();
		$endNum = ceil($num/$pageSize);	
		$thumbnails = new Thumbnails($con);
		$thumb = $thumbnails->getThumbnails();
	?>
	<style>
	 .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
	</style>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><a href="watch.php?id=<?php echo $thumb[0]['video_id']?>"><img src="<?php echo $thumb[0]['file_path'];?>"></img></a></div>
        <div class="swiper-slide"><a href="watch.php?id=<?php echo $thumb[1]['video_id']?>"><img src="<?php echo $thumb[1]['file_path'];?>"></img></a></div>
        <div class="swiper-slide"><a href="watch.php?id=<?php echo $thumb[2]['video_id']?>"><img src="<?php echo $thumb[2]['file_path'];?>"></img></a></div>
        <div class="swiper-slide"><a href="watch.php?id=<?php echo $thumb[3]['video_id']?>"><img src="<?php echo $thumb[3]['file_path'];?>"></img></a></div>
        <div class="swiper-slide"><a href="watch.php?id=<?php echo $thumb[4]['video_id']?>"><img src="<?php echo $thumb[4]['file_path'];?>"></img></a></div>
    </div>
    <!-- 如果需要分页器 -->
  	<div class="swiper-pagination"></div>
    
    <!-- 如果需要导航按钮 
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
   	 如果需要滚动条 
   <div class="swiper-scrollbar"></div>-->
</div>

			<div class="mian-broadcast-container">
				<?php $videos->getVideoHref($offset,$limit);?>
			</div>
			</div>
				<div class='root-page-function'>
				<a href='?pageNum=1'>首页</a>
				<a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>">上一页</a>
				<a href="?pageNum=<?php echo $pageNum==$endNum?$endNum:($pageNum+1)?>">下一页</a>
				<a href='?pageNum=<?php echo $endNum?>'>尾页</a>
				</div>
		
			</div>
		</div>
<script type="text/javascript">        
var mySwiper = new Swiper ('.swiper-container', {
        direction: 'horizontal',
        loop: true,
        // 如果需要分页器
        pagination: '.swiper-pagination',

        // 如果需要前进后退按钮
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        autoplay: true,
        speed: 500,
        // 如果需要滚动条
//         scrollbar: '.swiper-scrollbar',
        effect : 'coverflow',
        slidesPerView: 5,
        centeredSlides: true,
        coverflow: {
            rotate: 10,
            stretch: 10,
            depth: 30,
            modifier: 2,
            slideShadows : true
        }
  });
</script>
</body>
</html>
