<?php
session_start();
include("Database.php");
$id = $_SESSION['user'];
$one = '1';
//database for unread recieved messages
$query = mysql_query("SELECT * FROM `messages` WHERE `toid` = '$id' AND `read`= 0");

//database for read recieved messages
$query1 = mysql_query("SELECT * FROM `messages` WHERE `toid` = '$id' AND `read`= 1");

//database for sent messages
$query2 = mysql_query("SELECT * FROM messages WHERE fromid =". $_SESSION['user']);

if($_POST['submit']){
    $_SESSION['subject'] = $_POST['udel'];
    }
if($_POST['sub1']){
    $_SESSION['subject'] = $_POST['del'];
} 
/*
* THIS HTML CODE DISPLAYS THE MESSAGES USING ABOVE QUERIES
* AND INCLUDES BUTTONS FOR OPTIONS LIKE REPLY AND DELETE
*/
?>
<html>
<title>Messages</title>
<body>
<h3>Unread Messages</h3>
<table cellpadding="1" cellspacing="1" border="1">
  	<tr>
    <th>From-</th><th>Subject-</th>
    <th>Message-</th><th>Date-</th>
    <th>Mark as Read?</th><th>Delete?</th>
    <th>Reply</th>
    </tr>
<?php while($row1 = mysql_fetch_array($query)) {
    $currentSub1 = $row1['subject'];  ?>
	<tr>
    <td><?php echo $row1['fromEmail']; ?></td>
    <td><?php echo $row1['subject']; ?></td>
    <td><?php echo $row1['message']; ?></td>
    <td><?php echo $row1['date']; ?></td>
    <td><form name = "hello" method="POST" action="readm.php">
    <input type="hidden" name="read" value="<?php echo $currentSub1; ?>" />
    <input type="submit" name ="sread" value="Mark As Read" />
    </form></td>

    <td><form method="POST" action="deletem.php">
    <input type="hidden" name="udel" value="<?php echo $currentSub1; ?>" />
    <input type="submit" name ="submit" value="Delete" />
    </form></td>

    <td><form name = "reply" method="POST" action="reply.php">
    <input type="hidden" name="reply" value="<?php echo $currentSub1; ?>" />
    <input type="submit" name ="ureply" value="Reply" />
    </form></td>

	</tr>
<?php 

}
?>  
</table>

<h3>Read Messages</h3>
<table cellpadding="1" cellspacing="1" border="1">
  <tr>
    <th>From-</th><th> Subject-</th>
    <th>Message-</th><th> Date</th>
    <th>Delete?</th><th>Reply</th>
  </tr>
<?php while($row2 = mysql_fetch_array($query1)) {
        $currentSub2 = $row2['subject'];
 ?>
 <tr>
    <td><?php echo $row2['fromEmail']; ?></td>
    <td><?php echo $row2['subject']; ?></td>
    <td><?php echo $row2['message']; ?></td>
    <td><?php echo $row2['date']; ?></td>
    <td><form method="POST" action="deletem.php">
    <input type="hidden" name="del" value="<?php echo $currentSub2; ?>" />
    <input type="submit" name ="sub1" value="Delete" />
    </form></td>

    <td><form name = "reply" method="POST" action="reply.php">
    <input type="hidden" name="reply1" value="<?php echo $currentSub2; ?>" />
    <input type="submit" name ="rreply" value="Reply" />
    </form></td>
 </tr>
<?php
} 
?>  
</table>

<h3>Sent Messages</h3>
<table cellpadding="1" cellspacing="1" border="1">
  <tr>
 <th>To-</th><th>Subject-</th>
    <th>Message-</th><th>Date-</th>
  </tr>
<?php while($row3 = mysql_fetch_array($query2)) { ?>
 <tr>
    <td><?php echo $row3['toEmail']; ?></td>
    <td><?php echo $row3['subject']; ?></td>
    <td><?php echo $row3['message']; ?></td>
    <td><?php echo $row3['date']; ?></td>
 </tr>
<?php } ?>  
</table>
</body>
</html>
