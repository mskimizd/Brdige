<?php
include('apps/bridge/lib/user.php');
include('apps/bridge/lib/email.php');

class Database {
	public $db_host;
	public $db_name;
	public $db_user;
	public $db_password;
	public $db_prefix;

	public $db_conn = false;

	public function __construct(){
		$this->db_host = OC_Appconfig::getValue('bridge', 'db_host','');
		$this->db_name = OC_Appconfig::getValue('bridge', 'db_name','');
		$this->db_user = OC_Appconfig::getValue('bridge', 'db_user','');
		$this->db_password = OC_Appconfig::getValue('bridge', 'db_password','');
		$this->db_prefix = OC_Appconfig::getValue('bridge', 'db_prefix','');	
		
		$this->db_conn = mysql_connect($this->db_host,$this->db_user,$this->db_password);
		mysql_select_db($this->db_name, $this->db_conn);	
		
		if (!$this->db_conn)
		{
			die('Could not connect: ' . mysql_error());
		}
	}
	
	public function copyUsersInfo(){
		$q = 'SELECT username, user_email,group_id FROM '. $this->db_prefix .'users WHERE user_type = 0 OR user_type = 3';
		$result = mysql_query($q);
		
		while($row = mysql_fetch_assoc($result)){		
			if(!empty($row['username'])) {	
				if(!OC_User::userExists($row['username']))
					User::createUser($row['username']);
				$groupName=$this->getGroupNamebyId($row['group_id']);
				if(!OC_Group::groupExists($groupName))
					OC_Group::createGroup($groupName);
				OC_Group::addToGroup($row['username'],$groupName);
				//if(!empty($row['user_email'])){
				//	Email::sendEmail($row['username'],$row['user_email'],User::$password);
				//}
			}
		}
	}
	
	public function getUsers(){
		$usersList = array();
	
		$q = 'SELECT username FROM '. $this->db_prefix .'users WHERE user_type = 0 OR user_type = 3';
		$result = mysql_query($q);

		while($row = mysql_fetch_assoc($result)){
			if(!empty($row['username'])) {	
				$usersList[] = $row['username'];
			}
		}
		
		return $usersList;
	}
	
	public function getGroupNamebyId($id){
		$q2 = 'SELECT group_name FROM '. $this->db_prefix .'groups WHERE group_id= '.$id;	
		$result_2 = mysql_query($q2);
		$row2 = mysql_fetch_assoc($result_2);	
				
		return $row2['group_name'];	
	}

	public function reverseSynch(){
		$db_users = $this->getUsers();
		$oc_users = OC_User::getUsers();
		foreach ($oc_users as $oc_user){
			$temp = 0;	
			foreach ($db_users as $db_user){
				if($oc_user==$db_user){
					$temp=1;
					break;
				}
			}
			if(($temp==0)&&($oc_user!='admin'))
				OC_User::deleteUser($oc_user);
		}
	}
}

?>