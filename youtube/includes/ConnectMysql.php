<?php
	class ConnectMysql{
		public $connectmysql = array(
			'dsn'=>'mysql:dbname=phpvideodev',
			'username'=>'root',
			'password'=>'zhaomeng11',
		);
		public $options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
		);
	}
?>
