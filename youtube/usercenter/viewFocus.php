<?php 
	require_once('./../includes/classes/Focus.php');
	require_once('./../includes/config.php');
	$username = $_SESSION['userLoggedIn'];
	$focus = new Focus($con, $username);
	if(isset($_GET['id'])){
		$id = $_GET['id'];	
		//echo $id;die;
		$focus->delFansById($id);
	}
	$focus->getFocusHref($username);
	
?>
<!DOCTYPE>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="./../assets/jQuery/jquery-3.3.1.min.js"></script>
</head>

<body>	
	<script>
		function cancleFocus(id) {
			id = Number(id);
			console.log(id);
			var buttonId = "#view-focus-button-"+String(id);
			console.log(buttonId);
			$.get("viewFocus.php",{id:id},function(){
				//console.log(1);
				alert('取消关注成功');
				$(buttonId).fadeOut();
			});
		};
	</script>
</body>
</html>
