<?php
require_once('./userCenter.php');
	/*
	href:https://blog.csdn.net/dream_successor/article/details/76682894
	bool session_start(void);开始一个会话，或者返回一个已存在的会话
	bool session_register(string name);登记一个新的变量为开始变量
	bool session_is_registered(string name);检查变量是否为已登记变量
	bool session_unregister(string anme);删除已注册的变量
	bool session_destroy(void);结束当前会话，并清除会话所有资源
	bool session_encode(void);session信息编码
	bool session_decode(string name);session信息解码
	bool session_name(string [name]);存取当前会话名称
	bool session_id(string [id]);存取当前会话标识号
	void session_unset();删除已注册的所有变量
	*/
	session_unset();
	session_destroy();
	header('Location:../index.php');

?>
