<?php
class User
{
	private $con;
	private $type;
	public function __construct($con, $type) {
		$this->con = $con;
		$this->type = $type;
	}
	public function getCount(){
		switch($this->type){
			case 1:
				$query = $this->con->prepare("select count(*) as total from users");
			break;
			
			case 22:
				$query = $this->con->prepare("select count(*) as total from rootusers");
			break;
		}
		$query->execute();	
		$total = $query->fetchall(PDO::FETCH_ASSOC);
		return $total[0]['total'];
	}
	public function getUserInfo() {
		switch($this->type) {
				case 1:
				$query = $this->con->prepare("select *from users");
				break;
				case 2:
				$query = $this->con->prepare("select *from rootusers");
				break;
		}
		$query->execute();
		$data  = $query->fetchall(PDO::FETCH_ASSOC);	
		$i = 0;
		$total = count($data);
		$ret = '';
		for(;$i<$total;$i++){
			$id = $data[$i]['id'];
			$name = $data[$i]['first_name'].$data[$i]['last_name'];
			$email = $data[$i]['email'];
			$signTime = $data[$i]['sign_up_time'];
			$username = $data[$i]['username'];
			$ret .=  "<tr>
                  <td><input type='checkbox'></td>
                  <td>$id</td>
                  <td>$username</a></td>
                  <td>$name</td>
                  <td class='am-hide-sm-only'>$email</td>
                  <td class='am-hide-sm-only'>$signTime</td>
                  <td>
                    <div class='am-btn-toolbar'>
                      <div class='am-btn-group am-btn-group-xs'>
                        <button class='am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only'><span class='am-icon-trash-o'></span> 删除</button>
                      </div>
                    </div>
                  </td>
                </tr>";

		}
		return $ret;
	}	

}
?>
