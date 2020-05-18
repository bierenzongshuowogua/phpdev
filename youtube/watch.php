<?php
	require_once('./includes/head.php');
	require_once('./includes/classes/Video.php');
	require_once('./includes/classes/VideoPlayer.php');
	require_once('./includes/classes/VideoInfoSection.php');
	require_once('./includes/classes/Comment.php');
	require_once('./includes/classes/Collection.php');
	require_once('./usercenter/Wallet.php');
	//	echo '不合法的地址';
	if(!isset($_SESSION['userLoggedIn'])){
		header("Location:signIn.php");	
	}

	$id = isset($_GET['id'])?$_GET['id']:0;
	$id = isset($_POST['id'])?$_POST['id']:$id;
	$videoId = isset($_GET['videoId'])?$_GET['videoId']:0;
	$video = new Video($con, $id, $userLoggedInObj);
	$username = $userLoggedInObj->getUserName();
	//获取视频id
	if(!$video->getVideoValid($id)) {
		echo '该视频存在不安全因素';
		return ;
	}
	if(isset($_GET['videoId']) && isset($_GET['id'])){
		
		$uploadedName=$video->getUploadedBy();
		$wallet = new Wallet($con, $uploadedName);
		if($_GET['option'] == 1){
			$video->incrementSupport();
			$wallet->addCoins(3);
		}
		else{
			$video->incrementDisSupport();
			$wallet->addCoins(1);
		}
	}
	//评论
	if(isset($_GET['id']) && isset($_GET['content'])) {
		$content = $_GET['content'];
		//var_dump($_SESSION['userLoggedIn']);
		if(strlen($content)==0){
			return ;
		}
		$id = $_GET['id'];
		$comment = new Comment($con);
		$comment->insertComment($userLoggedInObj->getUserName(),$id, $content);
		$uploadedName = $video->getUploadedby();
		$wallet = new Wallet($con, $uploadedName);
		$wallet->addCoins(5);
		return $comment->getComment($id);
	}
	//回复
	if(isset($_GET['id']) && isset($_GET['reply']) &&isset($_GET['parent_username'])){
//		var_dump($_GET);die;
		echo 123;
		$id = $_GET['id'];	
		$reply = $_GET['reply'];	
		$parent_username = $_GET['parent_username'];
		$comment = new Comment($con);
		$comment->addReply($id, $parent_username, $username, $reply);
	}
	//关注
	if(isset($_GET['id']) && isset($_GET['option']) && $_GET['option']==9) {
		echo $username.'要订阅'.$_GET['id'];
		$collect = new Collection($con, $username);
		$collect->addCollection($_GET['id']);
	
	}
	//echo $video->getId();
	$video->incrementViews();
	//echo $video->getTitle()."---";
	//echo $video->getViews();
?>
<script src='./assets/js/give-gift.js'></script>
<div class="watch-left-column">
	<?php 
		$videoPlayer = new VideoPlayer($video);
		echo $videoPlayer->create(true);
		
		$videoInfo = new VideoInfoSection($con, $video, $userLoggedInObj);
		echo $videoInfo->create();
	?>
	<div class="comment-input-form">
		<input type="text" class="comment_input" name="comment" placeholder="快来评论叭">
		<!--<input type="file" class="comment_pic" name="comment_pic" placeholder="123">-->
		<input type="submit" class="comment_ajax" name="comment_submit"  value="评论">
	</div>
	
	<div class="comment-reply-form" style="display:none">
		<input type="text" class="reply_input" name="reply" placeholder="想想写点什么" require>
		<input type="submit" class="reply_ajax" name="reply_submit" value="评论">
	</div>
	
	<div class="comment-areas">
		<button class="hide-videoid" style="display:none"><?php echo $id; ?></button>
		<button class="hide-userpic" style="display:none"><?php echo $userLoggedInObj->getUserPic();?></button>
		<button class="hide-username" style="display:none"><?php echo $userLoggedInObj->getUserName();?></button>
<!--	<span class="comment-static-title"> 全部评论</span>-->

		<?php
		$videoComment = new Comment($con);
		echo $videoComment->getComment($id);
		?>
	</div>
</div>
	<script>	
		function commentReply(parent_username){
			//var commentId = Number(commentId);
		
			//var replyhtml = "<input type=text class='reply-text'><button class='reply-cancle'>取消</button><button class='reply-confirm'>确认</button>";
			//$('.comment-areas').prepend(replyhtml);
			var reply = prompt("回复内容","");
			//console.log(reply);
			//console.log(parent_username);
			//$.post("watch.php",{id:<?php echo $id?>,commentId:commentId,text:reply},function(data){
			var data = {};
			var userName = $(".hide-username").text();
			var userPic = $(".hide-userpic").text();
			data['id']=<?php echo $id?>;
			data['reply'] = reply;
			data['parent_username'] = parent_username;
			console.log(data);
			$.ajax({
				url:"watch.php",
				type:"GET",
				data: data,
				async: true,
				dateType:'text',
				success:function(data){	
					//$(".like-button").html(data);
			//			console.log('succ');
				var add = "<div class='comment-area'><div class='comment-name'><img src="+userPic+"></img>"+userName+"</div>"+"<div class='comment-time'>刚刚"+"</div><div class='comments'>@"+parent_username+":"+reply+"</div></div>";
			//console.log(add);
				$(".comment-areas").prepend(add);
					},
				error:function(data){
					alert('点赞失败');
				},
				});
		}
		/*
		function commentReply(commentId){
			console.log(commentId);
			//var inputReply = prompt("回复内容","");
			//commentId = Number(commentId);
			//console.log(commentId);
			var reply_class = '.reply-input-'+commentId;
			//console.log(reply_class);
			$(reply_class).show();
			var comment_reply_text = '.reply-text-'+commentId;
			var comment_reply_cancle = '.reply-cancle-'+commentId;
			var comment_reply_confirm = '.reply-confirm-'+commentId;
			//console.log(comment_reply_text);
			//console.log(comment_reply_cancle);
			//console.log(comment_reply_confirm);
			//var inputText = $(comment_reply_text).val();
			//var inputText1 = $(comment_reply_text).text();
			//var inputText2 = $(comment_reply_text).html();
			//console.log($("input").val());
			$(comment_reply_cancle).click(function(){
				$(comment_reply_text).val('');
				$(reply_class).hide();
			});
			$(comment_reply_confirm).click(function(){
				var inputText = $(comment_reply_text).val();
				console.log(inputText.length);
				if(inputText.length != 0) {
				$.post("watch.php",{comment_id:commentId},function(){
					console.log(inputText);			
					if($('#commentreply').hasClass(reply_class)){
					alert(22);
						$('#commentreply').toggleClass(comment_reply_text);
					}
					//内容清空
					$(comment_reply_text).val('');
					//inputText = $(comment_reply_text).val();
					//console.log(inputText);			
					$(reply_class).remove(comment_reply_text);
				});
				}
			});
		}
		*/
		function likeVideo(){
			//btn = document.getElementsByClassName("like-button");
			support = document.getElementsByClassName("text");
			var videoId = <?php echo $videoId?>;
			var id = <?php echo $id?>;
			var data={};
			data['videoId'] = videoId;
			data['id'] = id;
			data['option'] = 1;
			$.ajax({
				url:"watch.php",
				type:"GET",
				data: data,
				async: true,
				dateType:'text',
				success:function(data){	
					//$(".like-button").html(data);
					var supportNumber = support[1].innerText;
					support[1].innerHTML = Number(supportNumber)+1;
					//support[0].HTML(data);
					//alert(data);
					},
				error:function(data){
					alert('点赞失败');
				},
				});
			}
		function dislikeVideo(){
			//btn = document.getElementsByClassName("dislike-button");
			dissupport = document.getElementsByClassName("text");
			var videoId = <?php echo $videoId?>;
			var id = <?php echo $id?>;
			var data={};
			data['videoId'] = videoId;
			data['id'] = id;
			data['option'] = 2;
			$.ajax({
				url:"watch.php",
				type:"GET",
				data: data,
				async: true,
				dateType:'text',
				success:function(data){	
					//$(".like-button").html(data);
					var dissupportNumber = dissupport[2].innerText;
					dissupport[2].innerHTML = Number(dissupportNumber)+1;
					},
				error:function(data){
					alert('点赞失败');
				},
				});
			}
	$(document).ready(function(){
		/*
		$(".comment-reply").click(function(){
			alert("暂未完成开发");
		});
		*/
		$(".comment_ajax").click(function(){
			var text = $(".comment_input").val();
			var id = $(".hide-videoid").text();
			var userName = $(".hide-username").text();
			var userPic = $(".hide-userpic").text();
			//console.log(id);
			//console.log(userName);
			//console.log(userPic);
			//console.log(text);
	//		alert(<?php echo $id;?>);
			//var comment_name = $(".comment-areas").html();
			if(text.length==0){alert('请先输入内容');return false;}
			$.get("watch.php",{content:text,id:id,},function(data){
			var add = "<div class='comment-area'><div class='comment-name'><img src="+userPic+"></img>"+userName+"</div>"+"<div class='comment-time'>刚刚"+"</div><div class='comments'>"+text+"</div></div>";
			//console.log(add);
				$(".comment-areas").prepend(add);
			});
		});
	});
	/*
	$(document).ready(function(){
		$(".comment-reply").click(function(){
		//	var commentid = $(".comment-id");
			//console.log(commentid.html());
		//	console.log(commentid.text());
			
		});
	});
	*/
	$(document).ready(function(){
		$(".mycollection").click(function(){
			var id = <?php echo $id?>;
			console.log(id);
			var option = '9';
			$.get("watch.php",{id:id,option:option},function(){
				console.log('succ');
				alert('收藏成功,可去我的收藏中查看');
			});
		});
	});
	
	</script>
<div class="suggestions">

</div>

</div>
</div>
</div>
</body>
</html>
