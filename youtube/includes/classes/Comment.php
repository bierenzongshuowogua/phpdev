<?php
class Comment{
	private $con;
	private $commentData;
	public function __construct($con) {
		$this->con = $con;
	}
	public function addReply($videoId, $parent_username, $username, $reply){
		$query = $this->con->prepare("insert into comments(video_id,parent_username,child_username,parent_comment) values(:video_id,:parent_username,:child_username,:parent_comment)");
		$query->bindParam(":video_id", $videoId);
		$query->bindParam(":parent_username",$username);	
		$query->bindParam(":child_username",$parent_username);
		$query->bindParam(":parent_comment",$reply);
		return $query->execute();
	}
	public function getComment($videoId) {
		$query = $this->con->prepare("select *from comments where video_id=:video_id order by comment_time desc");
		$query->bindParam(":video_id", $videoId);
		$query->execute();
		$commentData = $query->fetchall(PDO::FETCH_ASSOC);
		$ret='';
		if($query->rowCount()!=0){
		for($i = 0;$i<$query->rowCount();$i++){
			$parent_username = $commentData[$i]['parent_username']==NULL?'无名游客':$commentData[$i]['parent_username'];
			$parent_comment = $commentData[$i]['parent_comment'];
			$comment_time = $commentData[$i]['comment_time'];
			$comment_like = $commentData[$i]['comment_like'];
			$comment_dislike = $commentData[$i]['comment_dislike'];
			$comment_id = $commentData[$i]['id'];
			$comment_reply_class = 'reply-input-'.$comment_id;
			$comment_reply_text = 'reply-text-'.$comment_id;
			$comment_reply_cancle = 'reply-cancle-'.$comment_id;
			$comment_reply_confirm = 'reply-confirm-'.$comment_id;
			$comment_reply_button = 'comment-reply-'.$comment_id;
			//echo $commentData[$i]['child_username'];
			//$son_username = $commentData[$i]['child_username']==' '?'':'@'.$commentData[$i]['child_username'].':';
			$son_username = $commentData[$i]['child_username']==' '?'':$commentData[$i]['child_username'];
			if($son_username!=''){
				$cmt = '@'.$son_username.':'.$parent_comment;
			}else{
				$cmt = $parent_comment;
			}
			//echo $son_username;
			//$comment_classid = 'comment-id-'.$comment_id;
			//$comment_replyid = 'comment-reply-'.$comment_id;
			$user = new User($this->con, $parent_username);
		
			$comment_parent_pic = $user->getUserPic()==NULL?'../assets/imgs/logo.png':$user->getUserPic();		
		//	<span class='comment_id' comment_classistyle='display:normal'>$comment_id</span>
 							//<img src='$comment_parent_pic' alt='...' class='img-circle'>
			 $ret .= "
					<div class='comment-area'>
			 			<div class='comment-name'>
							<img src='$comment_parent_pic' class='img-circle' alt='评论者头像'></img>
							$parent_username
						</div>
						<div class='comment-time'>
							$comment_time
						</div>
					<div class='comments'>
						$cmt
						<button id='comment-reply' class='$comment_reply_button' onclick='commentReply(\"$parent_username\")'>回复</button>
					</div>
				</div>
				";
		//	<button class='comment-reply'>回复</button>
		
					//<div id='commentreply' class='$comment_reply_class' style='display:none'>
					//<input type='text' name='reply-text' class='$comment_reply_text'>
				//	<button class='$comment_reply_cancle'>取消</button>
				//	<button class='$comment_reply_confirm'>确认</button>
				//	</div>
		}
		return $ret;
		}else {
			echo '暂无评论';
		}
	}
	public function insertComment($parent_name, $video_id, $parent_comment){
	
//		var_dump($parent_name);
//		var_dump($video_id);
//		var_dump($parent_comment);
		$video_id = intval($video_id);
		$parent_name = strval($parent_name);
		$parent_comment = strval($parent_comment);
		/*
		var_dump($parent_name);
		var_dump($video_id);
		var_dump($parent_comment);
		$query = $this->con->prepare("insert into comments(
														parent_username, 
														parent_comment
													values(
														$parent_name,
														$parent_comment
														)
									");
		*/
		$sql = "insert into comments(parent_username, parent_comment, video_id) values('$parent_name', '$parent_comment', $video_id)";
		$ret =$this->con->exec($sql);
		return $ret;
	}
	public function delComment($comment_id, $username){
		$query = $this->con->prepare("delete from comments where id=:id and parent_username=:username");
		$query->bindParam(":id", $comment_id);
		$query->bindParam(":username", $username);
		return $query->execute();
	}
	
}

?>
