<?php
class VideoSubscribe{
	private $con;
	public function __construct($con) {
		$this->con = $con;
	}
	public function getFocusVideoCount($username){
		$query = $this->con->prepare("select focus from focus where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($data)==0) {
			return ;
		}
				
		$data = array_column($data,'focus');
		$sql = '';
		foreach($data as $value=> $key) {
			$sql .= "'".$key."',";
		}
		//echo $sql;
		$sql = substr($sql,0,strlen($sql)-1);
		//echo $sql;
		$query = $this->con->prepare("select count(*) as num from videos where uploaded_by in ($sql)");
		//var_dump($query);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		return $ret[0]['num'];
	}
	public function getVideoHref($offset, $limit, $username) {
		$query = $this->con->prepare("select focus from focus where username=:username");
		$query->bindParam(":username", $username);
		$query->execute();
		
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($data)==0) {
			echo '暂无关注用户，赶快去关注用户吧';
			return ;
		}
				
		$data = array_column($data,'focus');
		$sql = '';
		foreach($data as $value=> $key) {
			$sql .= "'".$key."',";
		}
		//echo $sql;
		$sql = substr($sql,0,strlen($sql)-1);
		//echo $sql;
		$query = $this->con->prepare("select *from videos where uploaded_by in ($sql) limit $limit offset $offset");
		//var_dump($query);
		$query->execute();
		$retArr = [];
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($ret)>0) {
			$i = 0;
			foreach($ret as $value=>$key)	{
				$retT = $this->getVideoThumbnails($key['id']);
				//var_dump($retT);die;
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
			}else{
				echo '暂无关注用户，赶快去关注用户吧';
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
