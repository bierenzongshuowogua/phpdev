<?php
class VideoProcessor{
	private $con;
	private $sizeLimit = 500000000;
	private $ffmpegPath;	
	private $ffprobePath;
	private $videoTypes = array('avi', 'wmv', 'mpeg', 'mp4', 'rmvb', '3gp', 'mkv', 'flv');
	
	public function __construct($con){
		$this->con = $con;
		//Windows 配置
		//$ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
		//$ffmprobePath = realpath("ffmpeg/bin/ffmrobe.exe");
	}
	public function uploadVideo($videoUploadData){
		$targetDir = "uploads/videos/";
		$videoData = $videoUploadData->videoDataArray;
		$tempFilePath = $targetDir.uniqid().basename($videoData['name']);
		$tempFilePath = str_replace(" ", "_", $tempFilePath);
		$isValidData = $this->processData($videoData, $tempFilePath);
		if(!$isValidData) {
			return false;
		}
		//上传成功
		//TODO 1)转移视频
		if(move_uploaded_file($videoData['tmp_name'], $tempFilePath)) {
			$finalFilePath = $targetDir.uniqid().'.mp4';
			/*
			else {
				echo '插入成功!';
			}
			*/
			//判断视频转码是否成功
			if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
				echo 'NOTICE:视频格式转换失败!';
				return false;
			}		
				//删除原始视频文件
			if(!$this->deleteFile($tempFilePath)){
				return false;	
			}
			//插入到数据表
			if(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
				echo '插入视频数据表失败';
				return false;	
			}	
			//生成缩略图
			if(!$this->generateThumbnails($finalFilePath)) {
				echo 'NOTICE:获取视频时长失败!';
				return false;
			}
			//echo '缩略图制作成功!';
			return true;
		}		
		return false;
	}
	//验证视频数据是否正确--大小--格式--等等
	private function processData($videoData, $tempFilePath){
		$videoType = pathInfo($tempFilePath, PATHINFO_EXTENSION);//取后缀
	//	var_dump($videoData);
		if(!$this->isValidSize($videoData)) {
			echo 'NOTICE:视频大小超过限制';
			return false;
		}elseif(!$this->isValidType($videoType)){
			echo 'NOTICE:您上传的文件类型为：'.$videoType.'<br />';
			echo 'NOTICE:文件类型错误!';
			return false;
		}elseif($this->hasError($videoData)){
			echo 'NOTICE:文件上传失败!';
			return false;
		}
		return true;
			
	}	
	
	private function isValidSize($videoData) {
		return $videoData['size'] <= $this->sizeLimit;
	}	
	
	private function isValidType($videoType) {
		$lowercased = strtolower($videoType);
		return in_array($lowercased, $this->videoTypes);
	}
	private function hasError($videoData) {
		return $videoData['error']!=0;
	}
	//插入视频数据
	private function insertVideoData($videoUploadData, $finalFilePath) {
		$query = $this->con->prepare("insert into videos(uploaded_by, title, description, privacy, file_path, category)
									values(:uploaded_by, :title, :description, :privacy, :file_path, :category)
										");		
		$query->bindParam(":uploaded_by", $videoUploadData->uploadBy);
		$query->bindParam(":title", $videoUploadData->title);
		$query->bindParam(":description", $videoUploadData->description);
		$query->bindParam(":privacy", $videoUploadData->privacy);
		$query->bindParam(":file_path", $finalFilePath);
		$query->bindParam(":category", $videoUploadData->category);
		//$myTime = date("Y-m-d H:i:s", time());
		//$query->bindParam(":upload_date", date("Y-m-d H:i:s", $myTime));
		//$query->bindParam(":upload_date", $myTime);
		
		return $query->execute();
		
	}
	//视频格式转换为mp4
	private function convertVideoToMp4($tempFilePath, $finalFilePath) {
		//$cmd = "ffmpeg -i $tempFilePath -c:v libx264 -strict -2 $finalFilePath 2>&1";
		//分辨率设置
		//$cmd = "/usr/local/ffmpeg/bin/ffmpeg -i $tempFilePath -vcodec h264 -s 320x240 $finalFilePath 2>&1";
		$cmd = "/usr/local/ffmpeg/bin/ffmpeg -i $tempFilePath -vcodec h264 $finalFilePath 2>&1";
		//echo $cmd.'<br />';
		$outPutLog = array();		
		exec($cmd, $outPutLog, $returnCode);
		//var_dump($outPutLog);
		//print_r($outPutLog);
		//echo $returnCode.'<br />';
		if($returnCode != 0 ){
			foreach($outPutLog as $line) {
				echo $line.'<br />';
			}
			return false;
		}
		
		return true;
	}
	//删除原视频
	private function deleteFile($tempFilePath){
		if(!unlink($tempFilePath)){
			echo 'NOTICE:删除原始视频失败!';
			return false;	
		}
		return true;
	}
	//生成缩略图
	private function generateThumbnails($filePath) {
		$thumbnailsSize = "210x118";
		$numThumbnails = 3;
		$pathToThumbnails = "uploads/videos/thumbnails";
		$duration = $this->getVideoDuration($filePath);
		//echo $duration;
		//echo $duration;
		
		$videoId = $this->con->lastInsertId();		

		if(!$this->updateDuration($duration, $videoId)) {
			echo 'NOTICE:视频时长写入失败!';
			return false;
		}
		//
		for($num=1;$num<=$numThumbnails;$num++) {
			$imageName = uniqid().'.jpg';
			$interval = ((int)$duration*0.8)/$numThumbnails*$num;
			$fullThumbnailPath = "$pathToThumbnails/$videoId-$imageName";
			//echo $fullThumbnailPath;		
	
			$cmd = "/usr/local/ffmpeg/bin/ffmpeg -i $filePath -ss $interval -s $thumbnailsSize -vframes 1 $fullThumbnailPath 2>&1";
			$outPutLog = array();
			exec($cmd, $outPutLog, $returnCode);
			if($returnCode != 0) {
				foreach($outPutLog as $line) {
					echo $line.'<br />';
				}	
				return false;
			}
			$selected = $num == 1 ? 1 : 0 ;
			$query = $this->con->prepare("insert into thumbnails(video_id, file_path, selected) 
											values(:video_id, :file_path, :selected)");
			$query->bindParam(':video_id', $videoId);
			$query->bindParam(':file_path', $fullThumbnailPath);
			$query->bindParam(':selected',$selected );
			$success = $query->execute();
			if(!$success) {
				echo '缩略图记录写入数据库失败';
				return false;
			}
		}	
			
		return true;
	}
	//获取视频时长
	private function getVideoDuration($filePath) {
		//使用ffmprobe命令 获取视频时长
		return shell_exec("/usr/local/ffmpeg/bin/ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");	
	}
	//时间格式的转换
	private function updateDuration($duration, $videoId) {
		$hours = floor((int)$duration / 3600);
		$mins = floor(((int)$duration / 60) % 60);
		$secs = floor(((int)$duration % 60));
		$hours = ($hours < 10) ? "0".$hours.":" : $hours.":";
		if($hours<1)$hours='';
		$mins = ($mins < 10) ? "0".$mins.":" : $mins.":";
		$secs = ($secs < 10) ? "0".$secs.":" : $secs;
		$duration =  $hours.$mins.$secs;
		//修改数据表记录
		$query = $this->con->prepare("update videos set duration=:duration where id = :videoId");
		$query->bindParam(':duration', $duration);
		$query->bindParam(':videoId', $videoId);
		//var_dump($query);
		$returnCode = $query->execute();
		//var_dump($returnCode);
		//var_dump($returnCode);
		return $returnCode;
	}
}

?>
