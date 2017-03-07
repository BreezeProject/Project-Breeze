<?php
session_start();
include("Database.php");
//checks if delete button was clicked on read.php
if($_POST['submit']){
	$_SESSION['subject'] = $_POST['udel'];
    }
if($_POST['sub1']){
    $_SESSION['subject'] = $_POST['del'];
} 

/*updates values in table to set the toid to 0 so that the message 
*will delete sets it to 0 so that no messages in the database 
*are actually deleted just dont appear on message screen
*/

$id = $_SESSION['user'];
$subject = $_SESSION['subject'];
$query = mysql_query("UPDATE `messages` SET `toid` = 0 WHERE `toid` = '$id' AND `subject` = '$subject'");
header("Location: read.php");
?>
<html>
<h3>
<?php echo $subject; ?>
</h3>
</html>