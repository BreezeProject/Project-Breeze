<?php
//creates the database
error_reporting(~E_DEPRECATED & ~E_NOTICE);

define('DBHOST', 'tund.cefns.nau.edu');
define('DBUSER', 'jls865');
define('DBPASS', 'bucky392');
define('DBNAME', 'jls865');
 
$connect = mysql_connect(DBHOST,DBUSER,DBPASS);
$dbconnect = mysql_select_db(DBNAME);
 
if ( !$connect) {
	die("Connection failure: " . mysql_error());
}
 
if ( !$dbconnect) {
	die("Database Connection failure: " . mysql_error());
}
?>