<?php
session_start();
include("Database.php");

$query = mysql_query("SELECT * FROM `gradebook` 
WHERE `classId` = '$classId' AND `studentId`= '$studentId'");

?>

<html>
<title>Gradebook</title>
<body>
<h3>Gradebook</h3>
<table cellpadding="5" cellspacing="3" border="1">
    <tr>
    <th> Assignment Name </th><th>maxPoints</th>
    <th>studentGrades</th><th>classId</th>
    <th>studentId</th>
    </tr>
<?php while($row1 = mysql_fetch_array($query)) 
{
    $currentSub1 = $row1['name'];  ?>
    <tr>
    <td><?php echo $row1['name']; ?></td>
    <td><?php echo $row1['maxPoints']; ?></td>
    <td><?php echo $row1['studentGrades']; ?></td>
    <td><?php echo $row1['classId']; ?></td>
    <td><?php echo $row1['studentId']; ?></td></tr>
<?php
}
    
?>
</body>
</html>