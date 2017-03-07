<?php
 session_start();
mysql_query("UPDATE 'useractivity' SET 'userlogout' = now() WHERE 'userid'=" .$_SESSION['user']);
 session_destroy();
 header("Location: index.php");
 ?>