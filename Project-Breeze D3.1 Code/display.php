<html>
<head>
<title>Download File From MySQL</title>
<h1> List of Downloadable Files </h1>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
<?php
 session_start();
 require('Database.php');

$query = "SELECT id, name FROM upload";
$result = mysql_query($query) or die('Error, query failed');
if(mysql_num_rows($result) == 0)
{
echo "Database is empty <br>";
}
else
{
?>
<ul>
<?php
while(list($id, $name) = mysql_fetch_array($result))
{
?>
<li><a href="download.php?id=<?php echo urlencode($id);?>"><?php echo urlencode($name);?></a> <br></li>
<?php
}
}

?>
</ul>
</body>
</html>
