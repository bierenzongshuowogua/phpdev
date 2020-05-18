<?php
class differentClass{
	private $con;
	public function __construct($con){
		$this->con = $con;
	}
	public function getVideoCounts() {
		$query = $this->con->prepare("select count(*) as num from videos");
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		return $ret[0]['num'];	

	}
	public function getVideoHref($offset, $limit, $class){
		$selectDate=date("Y-m-d H:i:s",time()-86400);
		$selectDate=strtotime($selectDate);
		switch($class){
			//推荐视频
			case 2:
				$query = $this->con->prepare("select * from videos where views>50 or upload_date>$selectDate order by views desc limit $limit offset $offset ");
			//	print_r($query);
			break;
			//古装
			case 3:
				$query = $this->con->prepare("select * from videos where category=6 limit $limit offset $offset ");
			break;
			//音乐
			case 4:
				$query = $this->con->prepare("select * from videos where category=3 limit $limit offset $offset ");
			break;
			//运动
			case 5:
				$query = $this->con->prepare("select * from videos where category=5 limit $limit offset $offset ");
			break;
			//movie
			case 6:
				$query = $this->con->prepare("select * from videos where category=4 limit $limit offset $offset ");
			break;
		}
		$query->execute();
		$retArr = [];
		if($query->rowCount()>=0) {
			$ret = $query->fetchall(PDO::FETCH_ASSOC);
			$i = 0;
			foreach($ret as $value=>$key)	{
				$retT = $this->getVideoThumbnails($key['id']);
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
			
				$name = isset($key['name'])?$key['name']:"管理员上传";
							/*上传者头像 取消添加
									<div class='uploaded_user_pic'>
										<img src='#' alt='' style='font-size:10px'></img>
									</div>
							*/
				$retHref[$i]="
						<div class='broadcast-box'>
								<a href='watch.php?id=$id' target='_blank'>
									<img src='$file_path' ></img>
									<div class='duration'>
										<div class='left'></div>
										<div class='right'><span>$duration</span></div>	
										<div class='ptitle'><span>$title</span></div>
									</div>
								</a>
								<div class='uploaded_user_info'>	
									<div class='uploaded_user_name'>
									<a href='persional.php?name=$name' target='_blank'>[up] $name</a>
									</div>
								
								</div>
						</div>
					";
				echo $retHref[$i];
				$i++;
			}
		}	
	}
	public function getVideoThumbnails($videoId){
		$query = $this->con->prepare("select file_path from thumbnails where video_id=:video_id and selected=1");
		$query->bindParam(":video_id", $videoId);
		$query->execute();
		if($query->rowCount()>=1) {
			$data = $query->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}else {
			return NULL;
		}
	}

}
?>

