<?php 
//Connect to DB
$database_name 		= 'christian_blog';
$db_user 					= 'christian_blogUS';
$db_pass 					= 'NL6w9JTNQFhdpAF7';

$db = new mysqli( 'localhost', $db_user, $db_pass, $database_name );

//if there was error, kill the page
if($db->connect_errno > 0){ // -> is how mysql accesses object methods and properties
	die('Could not connect to DB:'.$db->connect_error);
}

// no close php