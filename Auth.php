<?php
/**
* Auth is a simple authorization class for password protecting a web page or application
*
* usage:
* $auth = new Auth();
* if(!$auth->checkUser) $auth->doAuth();
*/

namespace Msqueeg/Lib;

class Auth
{
	protected $verified;

	function __construct()
	{
		$this->verified = array('user1' => 'password1', 'user2' => 'password2');

	}

	public function doAuth()
	{
		header('WWW-Authenticate: Basic realm="User Authentication"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'you cannot view this page';
		exit;
	}

	public function checkUser()
	{	
		$b = false;
		$phpAuthUser = $_SERVER['PHP_AUTH_USER'];
		$phpAuthPw = $_SERVER['PHP_AUTH_PW'];
		if($phpAuthUser != '' && $phpAuthPw != ''){
			if($this->verified[$phpAuthUser] == $phpAuthPw) $b = true;
		}
		retunr $b;
	}

}