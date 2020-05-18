<?php
	//require_once('./ConnectMysql.php');
	ini_set("display_errors", "On");
	error_reporting(E_ALL | E_STRICT);
	ob_start();
	session_start();
	date_default_timezone_set("Asia/Shanghai");
	$dsn = "mysql:dbname=phpvideodev";
	$username = "root";
	$password = "zhaomeng11";
//	$connectinfo = new ConnectMysql();
	$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
	);
	try{
		//$con = new PDO("mysql:dbname=phpvideodev;host=localhost","root","zhaomeng11");
		$con = new PDO($dsn,$username,$password,$options);
		/*
		$con = new PDO(
				$connectinfo->connectmysql['dsn'],
				$connectinfo->connectmysql['username'],
				$connectinfo->connectmysql['password'],
				$connectinfo->options
			);
		*/
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	//	$con->query('set names uft8');
		
	}catch(PDOException $e) {
		echo "数据库链接失败".$e->getMessage();
	}
	/*
	$query = $con->prepare("select *from youtube");
	$query->execute();
	while($row = $query->fetch(PDO::FETCH_ASSOC)){
		echo $row['name'];
	}
	*/

	
	

?>
