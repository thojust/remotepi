<?php 	
session_destroy();
$hostname=gethostname();
header("Location: http://$hostname.local/remote/");
	exit();?>
