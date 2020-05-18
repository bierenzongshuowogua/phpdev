<?php 
	require_once('./includes/head.php');
	require_once('./differentClass.php');
	$videos = new differentClass($con);
//	$limit = 100;
//	$offset = 0;
		$pageSize = 15;
		$pageNum = isset($_GET['pageNum'])?$_GET['pageNum']:1;
	//	echo $pageNum;
		$limit = $pageSize;
		$offset = ($pageNum-1)*$pageSize;
		$num = $videos->getVideoCounts();
		$endNum = ceil($num/$pageSize);
?>
			<div class="mian-broadcast-container">
				<?php $videos->getVideoHref($offset,$limit,2);?>
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
</body>
</html>
