<?php 	
if (isset($_SESSION)){session_destroy();}
$hostname=gethostname();
$path= __DIR__;
$dir= explode("/",$path);
$curr = $dir[count($dir)-2];
header("Location: http://$hostname/remotepi/");	
exit();
?>
