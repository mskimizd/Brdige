<?php

	include('apps/bridge/lib/database.php');
	
	$db =new Database();
	$db->copyUsersInfo();
	$db->reverseSynch();	

	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='http://localhost/owncloud/index.php/apps/bridge/settings.php'";
	echo "</script>";

	
?>