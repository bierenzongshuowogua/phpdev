<?php
	require('./includes/head.php');
	$keywords='';
	if(isset($_GET['keywords'])){
		$keywords = $_GET['keywords'];
	}
	$offset = 0;
	$limit = 10;

	function getVideoHref($keywords,$offset, $limit, $con){
		$query = $con->prepare("select * from videos where title like '%$keywords%' or description like '%$keywords%' limit $limit offset $offset");
		$query->execute();
		$retArr = [];
		if($query->rowCount()>=0) {
			$ret = $query->fetchall(PDO::FETCH_ASSOC);
			$i = 0;
			foreach($ret as $value=>$key)	{
				$retT = getVideoThumbnails($key['id'], $con);
				$retArr[$i]['id'] = $key['id'];
				$retArr[$i]['file_path'] = $retT[0]['file_path'];
				$retArr[$i]['title'] = $key['title'];
				$retArr[$i]['description'] = $key['description'];
				$retArr[$i]['name'] = $key['uploaded_by'];
				$retArr[$i]['duration'] = $key['duration'];
				$i++;
			}
			$retHref = [];
			$i = 0;
			//var_dump($retArr);
			foreach($retArr as $value=>$key) {
				$id = $key['id'];
				$file_path = $key['file_path'];
				$title = "【".$key['title']."】".$key['description'];
				$duration = $key['duration'];	
				$name = $key['name'];
				/*
				$retHref[$i]="
						<div class='broadcast-box'>
								<a href='watch.php?id=$id'>
									<img src='$file_path'></img>
									<div class='duration'>
										<div class='left'></div>
										<div class='right'><span>$duration</span></div>	
										<div class='ptitle'><p>$title</p></div>
									</div>
								</a>
								<div class='uploaded_userInfo'>
									<div class='uploaded_user_name'>
									<a href='persional.php?name=$name'>[up] $name</a>
									</div>
						</div>
						</div>
					";
					*/
				$retHref[$i]="
						<div class='broadcast-box'>
								<a href='watch.php?id=$id'>
									<img src='$file_path' ></img>
									<div class='duration'>
										<div class='left'></div>
										<div class='right'><span>$duration</span></div>	
										<div class='ptitle'><span>$title</span></div>
									</div>
								</a>
								<div class='uploaded_user_info'>	
									<div class='uploaded_user_name'>
									<a href='persional.php?name=$name'>[up] $name</a>
									</div>
								
								</div>
						</div>
					";
				echo $retHref[$i];
				$i++;
			}
		}	
	}
	function getVideoThumbnails($videoId, $con){
		$query = $con->prepare("select file_path from thumbnails where video_id=:video_id and selected=1");
		$query->bindParam(":video_id", $videoId);
		$query->execute();
		if($query->rowCount()>=1) {
			$data = $query->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}else {
			return NULL;
		}
	}

?>

			<div class="mian-broadcast-container">
				<?php getVideoHref($keywords, $offset, $limit, $con);?>
			</div>
	
		
			</div>
		</div>
</body>
</html>
