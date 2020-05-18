<?php
	require_once('./../includes/config.php');
	require_once('./../includes/classes/discussionArea.php');
	echo $_POST['text'];
	$disArea = new discussionArea($con);
	$username = $_SESSION['userLoggedIn'];
	$disArea->addDiscussion($username, $_POST['text']);
?>
