<?php 
	require_once('./includes/roothead.php');
	require_once('./includes/classes/rootUser.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>删除管理员</title>
</head>

<body>
	<div id="delete-rootuser-form">
	<form action="deleteAdministrators2.php" method="POST" >
	<input type="text" name="username" placeholder="用户名" require>
	<input type="submit" name="delete_button">
	</form>	
	</div>
</body>

</html>
