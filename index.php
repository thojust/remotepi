<?php
include 'db.inc.php';
session_start();/// open session to read session data passed from loading.php
/*## Compiled by Justin Thomas 2020 ###
### thojust@gmail.com ######

### Credits ####
####based on tutorial here: https://www.element14.com/community/community/raspberry-pi/raspberrypi_projects/blog/2014/04/02/pi-webpage-reboot
#### and setting up .htaccess https://www.debiantutorials.com/password-protecting-a-directory-with-apache-and-htaccess/
#### and setting up apache and install php https://www.raspberrypi.org/documentation/remote-access/web-server/apache.md
#### and stats python code taken https://learn.pimoroni.com/tutorial/networked-pi/raspberry-pi-system-stats-python

### See python/config.tx for full install instructions */
$from=$_SERVER['HTTP_REFERER']; // see where they came from
if(isset($_SESSION['home'])){ $home= $_SESSION['home'];session_destroy();} /// see if loading.php is needed
$starttime = microtime(true); // Top of page// timing how long page takes to load 
$success= $_GET['success'];//Return message after Reboot or Shutdown
session_start();
$_SESSION['selfform']=1;
if(isset($_POST['status']) && $_SESSION['selfform']==1){$status = $_POST['status'];session_destroy();} //// Receive variables when Reboot or Shutdown is submited from this page to this page
///&& preg_match('#home?#',$from)
// apply fade in effect for first load only
/// Display Loading GIF For longer load ( home page no action)
if(empty($from) && !isset($success) && !isset($status)){header('Location:loading.php');die;}
if(empty($success) && !isset($home) && !isset($success) && !isset($status)) {header('Location: loading.php');
  exit(); }
  //pretty css fade in
if(isset($home)){$loading=1;}
if(isset($success) && isset($status)){$loading=1;}

$hostname= gethostname(); //name of raspi your controling

//// Run command if received

if ($status == "reboot"){
	exec("python /var/www/html/remote/python/reboot.py > /dev/null &");
	header('Location: .?success=1');
exit();
}

else if ($status == "shutdown"){
	exec("python /var/www/html/remote/python/shutdown.py > /dev/null &");
	header('Location: .?success=2');
	exit();
}

if($success==1){ $title="Rebooted";$message="<h2>Raspi Rebooted!</h2><br>";}
if($success==2){ $title="Shutdown";$message="<h2>Raspi Shutdown! </h2><p class=\"i\">You can safely unplug the pi </p>";}
if(empty($success)) {$title="Remote Control";$message= "<h2>Remote Control Raspi</h2>";};

?>
<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <link rel="icon"
      type="image/png"
      href="images/favicon.png">
  <title><?php echo $title . ":" . $hostname;?></title>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;469&family=Quicksand:wght@300&display=swap" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" media="only screen and (max-device-width: 9580px),only screen and (max-width: 9580px)" href="style.css" />
<link rel="stylesheet" type="text/css" media="only screen and (max-device-width: 480px),only screen and (max-width: 480px)" href="stylem.css" />
<script type="text/javascript">


// CLOSE WINDOW
function closewindow() {
self.opener = this;
self.close()
}


//// REBOOT PROMPT WITH WARNING
function reboot(){
      var ask=confirm("Are you sure you want to reboot the raspi  <?php echo $hostname;?>?");
      if(ask){
        document.getElementById("reboot_form").submit();// Form submission
       }
  }
//// SHUTDOWN PROMPT WITH WARNING
  function shutdown(){
       var ask=confirm("Are you sure you want to shut down the raspi <?php echo $hostname;?>? This will disconnect this interface and you will need to power on your pi manually");
       if(ask){
         document.getElementById("shutdown_form").submit();// Form submission
        }
   }


///NO PROMPTS:

/// LOGOUT
   function logout() {
          window.location="http://fakeuser:fake@<?php echo $hostname;?>.local/remote/logout/";
     }

     function refreshpage() {
          window.location="loading.php";
     }
</script>
</head>
<body>

<script> $("html").fadeOut(0);$("html").fadeIn(3000);</script>
<div id="wrapper"><div  class="lite" id= "hostname"><?php echo  $hostname; ?><div id="logout"><input class="logout"type="button" id="logout"  value="logout" onClick="logout()"/></div></div><?php echo $message;?>
<?php if(empty($success)) : ?>
<?php $stats= explode(',',exec('python /var/www/html/remote/python/stats.py')); echo  " storage: " . $stats[1] . "% full /memory:  " . $stats[0] . "% <br>";
$output[2] = exec('python /var/www/html/remote/python/temp.py'); $output[3] = exec('python /var/www/html/remote/python/cpuload.py') * 10 . "%";echo "temp: ". $output[2] . "°C / cpu load: " . $output[3];?>
<div id="footer"><input class="button"type="button" id="shutdown"  value="shutdown" onClick="shutdown()"/>
<input class="button"type="button" id="reboot"  value="reboot" onClick="reboot()"/><input class="button"type="button" id="refresh"  value="reload" onClick="refreshpage()"/></div>
<div class="hide"><form action="" method="post" id="reboot_form"><input type="hidden" value="reboot" name="status"/></form>
<form action="" method="post" id="shutdown_form"><input type="hidden" name="status"value="shutdown"/></form></div>
<?php endif;?>
<?php if(!empty($success)) : ?>
  <div id="logging"> Loggin out in &nbsp;</div><div id="counter">5</div>
    <script>
        setInterval(function() {
            var div = document.querySelector("#counter");
            var count = div.textContent * 1 - 1;
            div.textContent = count;
            if (count <= 0) {
                window.location.replace("http://fakeuser:fake@<?php echo $hostname;?>.local/remote/logout/");
            }
        }, 1000);
    </script>
<input class="button"type="button" id="logoutty"  value="logout" onClick="logout()"/><p>
<?php die;?>
<?php endif;?>
<?php // Code
$endtime = microtime(true); // Bottom of page
$loadtime= round($endtime - $starttime,2);
echo "<p class=\"lite\">Loaded in " . $loadtime . " seconds."; foreach ($guide as $guide){echo " Average  is " . round($guide['sec'],2) . " seconds </p>";}
// INSERT LOAD TIME INTO DB
$browser=$user_browser;
$os= $user_os;
$date=date("Y-m-d H:i:s");
$sql = "INSERT INTO pageload (sec, dates, browser,os)
VALUES ('$loadtime', '$date', '$browser', '$os')";
if ($link->query($sql) === TRUE) { // enter the data!  
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  $link->close();}
$link->close(); ?>
</div><img src="images/logoT.png">
</body>
