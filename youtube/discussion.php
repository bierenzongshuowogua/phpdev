<?php
	require_once('./includes/head.php');
	require_once('./includes/classes/discussionArea.php');
?>
	<div class='discussion-area'>
	<ul>
		<li><button><a href="community.php">社区讨论</a></button>
		<li><button><a href="submitError.php">内容反馈</a></button>
	</ul>
	</div>
	</div>
<script>
	$(document).ready(function(){
		$(".test").click(function(){
			//alert(123);
			$.post("ajax/discussion.php",{text:'1'}).done(function(data){
				alert(data);
			});
		});

	});
</script>
</html>
