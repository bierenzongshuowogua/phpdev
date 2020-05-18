<?php	
	require_once('./userCenter.php');
	require_once('./../includes/classes/Comment.php');
	if(isset($_GET['id'])) {
		$commentid = $_GET['id'];
		$username = $_SESSION['userLoggedIn'];
		$comment = new Comment($con);
		$comment->delComment($commentid, $username);
	}
	function getVideoHref($offset, $limit, $username, $con){
		$selectDate=date("Y-m-d H:i:s",time()-86400);
		$selectDate=strtotime($selectDate);
		$query = $con->prepare("select* from comments where parent_username='$username'");
		//$query->bindParam(":parent_username", $username);
		$query->execute();
		//$data = $query->fetchall(PDO::FETCH_ASSOC);
		//var_dump($data);die;
		//$query->bindParam(":username", $username);
//		var_dump($query);	
		$commentRet = $query->fetchall(PDO::FETCH_ASSOC);
		//var_dump($ret);
		$sql = array_column($commentRet,'video_id');
		//print_r($sql);die;
		$sql = array_unique($sql);
		//print_r($sql);die;
		$sql2='';
		foreach($sql as $k=>$v) {
			$sql2 .= $v.',';	
		}
		$sql2 = substr($sql2,0,strlen($sql2)-1);
		$query = $con->prepare("select *from videos where id in ($sql2)");
		//var_dump($query);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		//print_r($ret[0]);
		//print_r($commentRet[0]);
		$retArr = [];
		if(count($ret)>0) {
		//	$ret = $query->fetchall(PDO::FETCH_ASSOC);
		$i = 0;
		foreach($commentRet as $k=>$v) {
			$parent_comment = $v['parent_comment'];
			$commentsid = $v['id'];
			$video_id = $v['video_id'];
			foreach($ret as $k2=>$v2){
			if($v2['id'] == $v['video_id']) {
			$title = $v2['title'];
			$description = $v2['description'];
			$video_pic = getVideoThumbnails($v2['id'], $con);
			//print_r($video_pic);
			$video_pic_path = $video_pic[0]['file_path'];
			//print_r($video_pic);
			echo "<div class='mycomment-area' id='$commentsid'>
					<div class='mycomment-head'>
						<div class='mycomments'>
							$parent_comment
						</div>
						<div class='mycomments-del'>
						<button class='mycomments-del-button' onclick='delcomments($commentsid)'>删除</button>
						</div>
					</div>
					<div class='mycomment-url'>
					<a href='../watch.php?id=$video_id'>
						<div class='mycomment-img'><img src='../$video_pic_path' ></img></div>
						<div class='mycomment-title'><div>$description</div></div>
					</a>
					</div>
				</div>
				";
			}
			}
			$i++;		
		}//foreach($commentRet)
		}//if(count($ret)>0
	}
	function getVideoThumbnails($videoId, $con){
	//	echo $videoId;die;
		$query = $con->prepare("select file_path from thumbnails where video_id=:video_id and selected=1");
		$query->bindParam(":video_id", $videoId);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($ret)>=0){
			return $ret;
		}else{
			return false;
		}
	}
	$name = $_SESSION['userLoggedIn'];
	$limit = 100;
	$offset = 0;
?>
	<div class="mycomment-areas" type='overflow-y:scroll;'>
		<?php getVideoHref($limit, $offset, $username, $con);?>
	</div>
	<script>
	function delcomments(id){
		//console.log($("#12").html());
		//var delClass = "\"#"+id+"\"";
		//console.log(delClass);
		
		$.get("myComment.php",{id:id},function(){
			//var content = $("#"+id).remove();
			$("#"+id).fadeOut();return;
		//	console.log(content);
			//alert('删除成功');
		});
	}
	</script>
