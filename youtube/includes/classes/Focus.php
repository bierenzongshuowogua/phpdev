<?php
class Focus{
	private $con;
	private $username;
	public function __construct($con, $username){
		$this->con = $con;	
		$this->username = $username;
	}
	//获取关注列表
	public function getFocusHref($name) {
		$query = $this->con->prepare("select *from focus where username=:username");
		$query->bindParam(":username", $name);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
	//	print_r($ret);
	//	$data = array_column($ret, 'focus');
	//	print_r($data);die;
		if(count($data)==0)echo '暂无关注，赶快去关注一些人，增加点乐趣吧';
		$retStr = '<ul>';
		foreach($data as $value=>$key) {
			$username = $key['username'];
			$id = $key['id'];
			$classId = 'view-focus-button-'.$key['id'];
			$retStr .= "
					<li id='$classId'>
					<a href='./../persional.php?name='$username'>$username</a>	
					<button class='view-focus-button' onclick='cancleFocus($id)'>取消关注</button>
					</li>
					";
		}
		$retStr .= '</ul>';
		echo $retStr;
	}
	//获取粉丝列表
	public function getFansHref($name) {
		$query = $this->con->prepare("select *from focus where focus=:username");
		$query->bindParam(":username", $name);
		$query->execute();
		$ret = $query->fetchall(PDO::FETCH_ASSOC);
	//	print_r($ret);
		//$data = array_column($ret, 'username');
	//	print_r($data);
		if(count($ret)==0)echo '暂无粉丝，赶快发布一些视频增加粉丝吧';
		$retStr = '<ul>';
		foreach($ret as $value=>$key) {
			$username = $key['username'];
			$id = $key['id'];
			$classId = 'view-fans-button-'.$key['id'];
			//$classAId = 'view-fans-a-'.$key['focus'].'-'.$key['id'];
			$retStr .= "
					<li id='$classId'>
						<a href='./../persional.php?name='$username'>$username</a>
						<button class='view-fans-button' name='view-fans-button' onclick='cancleFans($id)' style='display:none'>取消关注</button>
					</li>
					";
		}
		$retStr .= '</ul>';
		echo $retStr;
	}

	public function addFocus($name) {
		$query = $this->con->prepare("select *from focus where username=:username and focus=:focus");
		$query->bindParam(":username", $this->username);
		$query->bindParam(":focus", $name);
		$query->execute();
		if($query->rowCount()>0){
			return true;
		}
		$query = $this->con->prepare("insert into focus(username,focus) values('$this->username', '$name')");
		return $query->execute();
	}
	public function getFocus($name){
		//echo $name;
		$query = $this->con->prepare("select count(*) as total from focus where username=:username");
		$query->bindParam(":username",$name );
		$query->execute();	
		//var_dump($query);
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		$ret = intval($data[0]['total']);
		//var_dump($ret);		
		return $ret;
		//return $query->rowCount();
		
	}
	public function getFans($name){
		//获取粉丝数量 查询focus数据库中的focus列
		$query = $this->con->prepare("select count(*) as total from focus where focus=:username");
		$query->bindParam(":username", $name);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		return $data[0]['total'];
	}
	public function delFocus($focus) {
		$query = $this->con->prepare("delete from focus where username=:username and focus=:focus");
		$query->bindParam(":username", $this->username);
		$query->bindParam(":focus", $focus);
		//var_dump($query->rowCount());
		return $query->execute();
	}
	public function delFocusById($id) {
		$query = $this->con->prepare("delete from focus where id=:id");
		$query->bindParam(":id", $id);
		return $query->execute();
	}
	public function delFansById($id) {
		$query = $this->con->prepare("delete from focus where id=:id");
		$query->bindParam(":id", $id);
		return $query->execute();
	}
	public function isFocus($name) {
		$query = $this->con->prepare("select *from focus where username=:username and focus=:focus");
		$query->bindParam(":username",$this->username);
		$query->bindParam(":focus",$name);
		$query->execute();
		$data = $query->fetchall(PDO::FETCH_ASSOC);
		if(count($data)>0){
			return "取消关注";
		}else {
			return "关注";
		}
	}

}

?>
