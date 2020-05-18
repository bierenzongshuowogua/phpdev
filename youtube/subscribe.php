<?php
	require_once('./includes/head.php');
	require_once('./includes/classes/VideoSubscribe.php');	
	if(!$_SESSION['userLoggedIn']){
		header("Location:signIn.php");
	}
	$username = $_SESSION['userLoggedIn'];
	//echo $username;
	$sub = new VideoSubscribe($con, $username);
//	$limit = 100;
//	$offset = 0;
		$pageSize = 15;
		$pageNum = isset($_GET['pageNum'])?$_GET['pageNum']:1;
	//	echo $pageNum;
		$limit = $pageSize;
		$offset = ($pageNum-1)*$pageSize;
		$num = $sub->getFocusVideoCount($username);
		$endNum = ceil($num/$pageSize);	
?>

			<div class="mian-broadcast-container">
				<?php $sub->getVideoHref($offset,$limit,$username);?>
			</div>
				<div class='root-page-function' style="display:none">
				<a href='?pageNum=1'>首页</a>
				<a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>">上一页</a>
				<a href="?pageNum=<?php echo $pageNum==$endNum?$endNum:($pageNum+1)?>">下一页</a>
				<a href='?pageNum=<?php echo $endNum?>'>首页</a>
					<?php echo '共'.$endNum.'页';?>
				</div>
				<script>
					$(document).ready(function(){
					function pageHide(){
						var num = <?php echo $num;?>;
						alert(num);
						var pageSize = <?php echo $pageSize;?>;	
						if(num<pageSize) {
							$(".root-page-function").hide();
						}
					}
				});
				</script>
				<div>
				<div>
	
		
			</div>
</div>
</body>
</html>
