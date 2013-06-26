<?php

/**
* ownCloud - user_redmine
*
* @author Steffen Zieger
* @copyright 2012 Steffen Zieger <me@saz.sh>
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
*
*/
//OC_Util::checkAdminUser();
//require_once('apps/bridge/lib/controler.php');
//require_once('apps/bridge/lib/user_phpbb3.php');

OCP\App::registerAdmin('bridge','settings');

// register user backend
//OC_User::useBackend( 'phpbb3' );

// add settings page to navigation
//if(OC_Group::inGroup( $_SESSION["user_id"], "admin" )) {
$approach=OC_Appconfig::getValue('bridge', 'approach','');
$run_style=OC_Appconfig::getValue('bridge', 'run_style','');

if($approach==1){
	require_once('apps/bridge/lib/user_phpbb3.php');	
	OC_User::useBackend( 'phpbb3' );	
}	

if(OC_User::isAdminUser(OC_User::getUser())) {

	if(($run_style==0)&&($approach==0))
		require_once('apps/bridge/controler.php');

	OCP\App::addNavigationEntry( array( 
		'id'   => 'bridge_settings',
		'order'=> 20,
		'href' => OC_Helper::linkTo( "bridge", "settings.php" ),
		'icon' => OCP\Util::imagePath( 'bridge', 'bridge.png' ),
		'name' => 'Bridge'
	));
}