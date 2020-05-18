<?php
	var_dump($_POST);
	var_dump($_GET);die;
	if(isset($_POST['content'])) {
		$comment = new Comment($con);
		$comment->insertComment($userLoggedInobj->getUserName, '',$video_id,$_POST['content'],'');
	}
?>
