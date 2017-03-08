<?php
error_reporting(~E_DEPRECATED & ~E_NOTICE);

//define('DBHOST', 'tund.cefns.nau.edu');
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'master');
 
$connect = mysql_connect(DBHOST,DBUSER,DBPASS);
$dbconnect = mysql_select_db(DBNAME);
 
if ( !$connect) {
	die("Connection failure: " . mysql_error());
}
 
if ( !$dbconnect) {
	die("Database Connection failure: " . mysql_error());
}
?>