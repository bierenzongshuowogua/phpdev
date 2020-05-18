
<?php
	require('./includes/head.php');
	require_once('./differentClass.php');
	$videos = new differentClass($con);
	$limit = 20;
	$offset = 0;
	$class = 3;
?>
			<div class="mian-broadcast-container">
				<?php $videos->getVideoHref($offset,$limit,$class);?>
			</div>
	
		
			</div>
		</div>
</body>
</html>
?>
