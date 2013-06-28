<?php
include('apps/bridge/lib/database.php');

class OC_User_phpbb3 extends OC_User_Backend {
	public $db_host;
	public $db_name;
	public $db_user;
	public $db_password;
	public $db_prefix;
	public $db_conn = false;
	public $db;	
    protected $all_users;	
	
	function __construct() {
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
		$this->db =new Database();		
	}

	public function getAllUsers() {
		
		$users = array();		
	
		$q = 'SELECT username FROM '.$this->db_prefix.'users WHERE user_type = 0 OR user_type = 3';
		$result = mysql_query($q);
		while ($row = mysql_fetch_assoc($result)) {
			if(!empty($row['username'])) {				
					$users[] = $row['username'];
			}
		}
		array_unique($users);
		return $users;
		
	}
	
  public function getUsers($search = '', $limit = NULL, $offset = NULL) { 
	//getUsers function
	trigger_error( "search: ".$search."limit: ".$limit."   "."offset: ".$offset );   
	$users=array();
	$start=0;
	$fin=sizeof($this->all_users);

	if($fin==0){
		$this->all_users=$this->getAllUsers();
		$fin=sizeof($this->all_users);
	}
	if($fin==0){
		return $users;
	}
	$nb_users=$fin;
	if($search==''){
		if($offset!=NULL) $start=$offset;
		if($limit!=NULL) $fin=$start+$limit; 
	}
	
	if($fin>$nb_users) $fin=$nb_users;
	for($i=$start ; $i<$fin ; $i++){
		if($search=='' || strpos($this->all_users[$i],$search)>-1){
			$users[] = $this->all_users[$i];
		}
    }
    return $users;
  }
  
  public function checkPassword($uid, $password){  
	OC_Util::setupFS($uid);	  
    $query = 'SELECT username,user_password,group_id FROM '.$this->db_prefix.'users WHERE username = "' . str_replace('"','""',$uid) . '"';
    $result = mysql_query($query);
    if ($result && mysql_num_rows($result)>0) {
      $row = mysql_fetch_assoc($result);
      $hash = $row['user_password'];
    $wp_hasher = new PasswordHash(8, TRUE);
    $check = $wp_hasher->CheckPassword($password, $hash);
    
      if ($check==true) {
		$groupName=$this->db->getGroupNamebyId($row['group_id']);
		if(!OC_Group::groupExists($groupName))
			OC_Group::createGroup($groupName);		
		OC_Group::addToGroup( $uid, $groupName);
        return $row['username'];
      }
    }
    return false;
  }
  public function userExists($uid) {
	OC_Util::setupFS($uid);	  
    $q = 'SELECT username FROM '.$this->db_prefix.'users WHERE username = "' . str_replace('"','""',$uid) . '"';
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
      return true;
    }	
    return false;
  }  
}