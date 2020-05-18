<?php
class Constants{
	public static $FIRSTNAME_ERROR = '姓氏长度不得超过25或小于2';
	public static $LASTNAME_ERROR = '名字长度不得超过25或小于2';
	public static $USERNAME_LENGTHERROR = '用户名不得超过25或小于3';
	public static $USERNAME_REPEATERROR = '用户名重复';
	public static $EMAIL_DONOTMATCHERROR = '两次邮箱输入不一致';
	public static $EMAIL_INVALIDERROR = '邮箱格式不正确';	
	public static $EMAIL_REPEATERROR = '邮箱重复';
	public static $PASSWORD_DONOTMATCHERROR = '两次密码不匹配';
	public static $PASSWORD_FUZADUERROR = '密码复杂度不够';
	public static $PASSWORD_LENGTHERROR = '密码长度不得超过30或小于5';
	public static $LOGINFAILED_ERROR = '登陆失败,密码错误';	
	public static $ORIGINAL_PASSWORD_ERROR = '原始密码错误';
	public static $STOP_COMMON_PAGESIZE=10;
	public static $ALL_COMMON_PAGESIZE=10;
	public static $ALL_ROOT_PAGESIZE=10;
	public static $USER_NOT_EXIST = '用户名不存在';
	public static $USER_IS_INSEAL = '用户正在停封';
	public static $USER_SEAL_SUCCESS = '用户封禁成功';
	public static $USER_UNSEAL_SUCCESS = '用户解封成功';
	public static $USER_UNSEAL_FAILED = '用户解封失败';
		
}

?>
