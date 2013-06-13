<?php

class User {
	public static $password;
	
	public static function createUser($userName){
		self::$password=self::randomPassword();
		OC_User::createUser($userName,self::$password);
	}
	
	public static function randomPassword(){
	
		$pw_length=8;
		$randpwd = '';
		for ($i = 0; $i < $pw_length; $i++) 
		{
			$randpwd .= chr(mt_rand(33, 126));
		}
		return $randpwd;
	}	
}

?>