<?php
 session_start();
 require('Database.php');

function getInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$text = getInput($_POST["text"]);
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}

$query = "INSERT INTO upload (name, size, type, content, text ) ".
"VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$text')";

mysql_query($query) or die('Error, query failed');

echo "<h3>File $fileName successfully uploaded!</h3>";


}
?>



<html>
<h4> Upload material here for the class:</h4>
<form method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr>
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
<input name="userfile" type="file" id="userfile">
<input name="text"  type="text" required placeholder="Enter a text for upload" style="height: 19px;" size="30"><br><br>

</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>
</html>