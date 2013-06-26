<?php

class Email{

	public static function sendEmail($uName,$uEmail,$uPassword){
		$from_address='mskimizd@gmail.com';
		$to_address=$uEmail;
		$username=$uName;
		$title='Welcome to ownCloud!';
		$content=' As a user of phpbb3 forum, you are automatically added as the ownCloud(the resource center of the phpbb3)
		Your username is still the username of phpbb3. Now your password is '.$uPassword.'. Highly recommend you to modify the password immediately.
		';	
		OC_Mail::send($to_address,$username,$title,$content,$from_address,'OC');
	}
}

?>