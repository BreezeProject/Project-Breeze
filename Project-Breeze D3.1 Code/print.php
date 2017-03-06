<?php
session_start();
include("Database.php");
$query = mysql_query("SELECT * FROM users WHERE userId =". $_SESSION['user']);
$query1=  mysql_query("SELECT * FROM useractivity WHERE userid =". $_SESSION['user']);
if(!$query){
	die($query);
}
if(!$query1){
	die($query1);
}
?>
<html>
<title>Printed Database</title>
<body>
<h3>users table for your userid</h3>
<table cellpadding="1" cellspacing="1" border="1">
  <tr>
    <th>userId</th><th>userName</th>
    <th>userEmail</th><th>userPass</th>
  </tr>
<?php while($row = mysql_fetch_array($query)) { ?>
  <tr>
    <td><?php echo $row['userId']; ?></td>
    <td><?php echo $row['userName']; ?></td>
    <td><?php echo $row['userEmail']; ?></td>
    <td><?php echo $row['userPass']; ?></td>
  </tr>
<?php } ?>   
</table>
<h3> useractivity table for your userid</h3>
<table cellpadding="1" cellspacing="1" border="1">
  <tr>
    <th>user login</th><th>user change</th>
    <th>user logout</th><th>userid</th>
  </tr>
<?php while($row1 = mysql_fetch_array($query1)) { ?>
  <tr>
    <td><?php echo $row1['userlogin']; ?></td>
    <td><?php echo $row1['userchange']; ?></td>
    <td><?php echo $row1['userlogout']; ?></td>
    <td><?php echo $row1['userid']; ?></td>
  </tr>
<?php } ?>   
</table>

</body>
</html> 