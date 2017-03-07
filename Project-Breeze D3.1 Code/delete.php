<?php
session_start();
include('Database.php');
	$result = mysql_query("SELECT 'userId' FROM users WHERE 'userId' =".$_SESSION['user']);
	$id = mysql_fetch_array($result);
if (strcmp($_SESSION['user'], $id['userId'])){

	$id = $_SESSION['user'];
	mysql_query("UPDATE useractivity SET userchange ='deleted account' WHERE userid =".$_SESSION['user']);mysql_query("UPDATE useractivity SET userdelete = 1 WHERE userid =".$_SESSION['user']);
	$result = mysql_query("DELETE FROM users WHERE userId=".$id) or die(mysql_error());

	session_destroy();
	header("Location: index.php");
}

?>