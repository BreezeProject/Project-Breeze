<?php
session_start();
include('Database.php');
$admin = 13;
//doesn't allow anyone not the admin to access
if($_SESSION['user'] != $admin){
	header("Location: main.php");
}
?>
<html>
<head>
<p> test</p>

</head>
<body>
<ul>
	<li><a href="message.php">Read Messages</a></li>
	<li><a href="ramessages.php">Read All Messages</a></li>
	<li><a href="deletem.php">Delete Messages</a></li>
 </ul>
</html>

