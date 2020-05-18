<?php
	require_once('./includes/roothead.php');
	require_once('./includes/classes/CommonUserInfo.php');
	require_once('./includes/classes/Constants.php');
	$pageNum = empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$pageSize = Constants::$STOP_COMMON_PAGESIZE;
	$commonUserInfo = new CommonUserInfo($con);
	$totalNum = $commonUserInfo->getStopCounts();
	$endPage = ceil($totalNum / $pageSize);
	$offset = ($pageNum-1)*$pageSize;
	$commonUserInfoArr = $commonUserInfo->getStopCommonInfo($offset,$pageSize);

	function getInfo($commonUserInfoArr){
		$ret='';
		foreach($commonUserInfoArr as $key=>$value){
			$ret .= '<tr>';
			foreach($value as $k=>$v){
				$ret .="<td align='center'>".$v.'</td>';
			}
			$ret .= '</tr>';
		}
		return $ret;
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>封停用户</title>
</head>
	
<body>
	<div id="stop-common-info-container">
	<table id="stop-common-info-table">
	<tr>
		<th>序号</th>
		<th>用户名</th>
		<th>姓</th>
		<th>名</th>
		<th>邮箱</th>
		<th>注册时间</th>
		<th>封禁</th>
	</tr>
		<?php 
			$ret = getInfo($commonUserInfoArr);
			echo $ret;
		?>  
	</table>
	</div>
	<div id="stop-page-function">
	<a href="?pageNum=1" rel="external nofollow">首页</a>	
	<a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>" rel="external nofollow">上一页</a>
	<a href="?pageNum=<?php echo $pageNum==$endPage?$endPage:($pageNum+1)?>" rel="external nofollow">下一页</a>	
	<a href="?pageNum=<?php echo $endPage ?>" rel="external nofollow">尾页</a>	
	</div>
</div>

</div>
</div>
</body>

</html>
