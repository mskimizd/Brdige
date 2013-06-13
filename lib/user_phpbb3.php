<?php
include('apps/bridge/lib/database.php');

class OC_User_phpbb3 extends OC_User_Backend {
    protected $all_users;
	protected $db;	
	
	function __construct() {
		$this->db =new Database();
	}	

	public function getAllUsers() {
		
		$users = array();		
	
		$q = 'SELECT username FROM phpbb_users WHERE user_type = 0 OR user_type = 3';
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
    $query = 'SELECT username,user_password,group_id FROM phpbb_users WHERE username = "' . str_replace('"','""',$uid) . '"';
    $result = mysql_query($query);
    if ($result && mysql_num_rows($result)>0) {
      $row = mysql_fetch_assoc($result);
      $hash = $row['user_password'];
    $wp_hasher = new PasswordHash(8, TRUE);
    $check = $wp_hasher->CheckPassword($password, $hash);
    
      if ($check==true) {
		$this->db->getGroupNamebyId($row['group_id']);
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
    $q = 'SELECT username FROM phpbb_users WHERE username = "' . str_replace('"','""',$uid) . '"';
    $result = mysql_query($q);
    if ($result && mysql_num_rows($result)>0) {
      return true;
    }	
    return false;
  }  
}