<?php
session_start();
include("Database.php");
//reads the subject in from form on read.php
if($_POST['sread']){
	$_SESSION['subject'] = $_POST['read'];

    }
//updates the message to read
$id = $_SESSION['user'];
$subject = $_SESSION['subject'];
$query = mysql_query("UPDATE `messages` SET `read` = 1 WHERE `toid` = '$id' AND `subject` = '$subject'");
header("Location: read.php");
?>