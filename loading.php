<?php
session_start();
$_SESSION['home']="home";
$hostname= gethostname() //name of raspi your controling update, automatically generated by a python script
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;469&family=Quicksand:wght@300&display=swap" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
localStorage.clear();
function loading() {

  //document.getElementById("loading_form").submit();// Form submission
  window.location="http://<?php echo $hostname;?>.local/remotepi/";
     }


</script>
<style>
body{
  text-align: center;
  
}
  

@media only screen and (max-device-width: 480px) {
 body {
 width:100%;
 margin-top:35%;
}
}


</style>
</head>
<body onload="loading()">
<img class="big" src="images/loadingm.gif"/><script> $("html").fadeOut(6000);</script>
</body>
</html>
