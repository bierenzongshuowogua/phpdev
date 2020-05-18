<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/rootAccount.php');
	require_once('./includes/classes/rootUserInfo.php');
	require_once('./includes/classes/Constants.php');
	$pageNum = empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$pageSize = Constants::$ALL_ROOT_PAGESIZE;
	$allUserInfo = new rootUserInfo($con);
	$totalNum = $allUserInfo->getCounts();
	$endPage = ceil($totalNum/$pageSize);
	$offset = ceil($pageNum-1)*$pageSize;
	$allUserInfoArr = $allUserInfo->getAllUserInfo($offset,$pageSize);

	function getInfo($allUserInfoArr){
		$ret = '';
		foreach($allUserInfoArr as $key=>$value){
			$ret .='<tr>';
			foreach($value as $k=>$v){
				$ret .= '<td>'.$v.'</td>';	
			}
			$ret .= '</tr>';
		}
		//$ret .= '</table>';
		return $ret;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title> 用户信息</title>

</head>

<body>
	<div id="get-all-user-info-container">
		<div id="table-head">
		<table id="all-user-info-table">
			<tr>
			<th>序号</th>
			<th>管理员账号</th>
			<th>添加管理员</th>
			<th>操作时间</th>
			</tr>
			<?php $ret=getInfo($allUserInfoArr);
				echo $ret;			
			?>
		</table>
		</div>
		<div id="root-page-function">
		<a href="?pageNum=1"?>首页</a>
		<a href="?pageNum=<?php echo $pageNum==1?$pageNum:($pageNum-1)?>">上一页</a>
		<a href="?pageNum=<?php echo $pageNum==$endPage?$endPage:($pageNum+1)?>">下一页</a>
		<a href="?pageNum=<?php echo $endPage?>">尾页</a>
		</div>
	</div>




	</div>
</div>
</body>

</html>
