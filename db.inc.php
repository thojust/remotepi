<?php
//GET VARIABLES IF NEEDED


//CONNECT TO MYSQL SERVER
$link = mysqli_connect('localhost', 'admin', 'relax');
if (!$link)
{
echo 'Unable to connect to the database server.';
exit();
}
//CHECK CHARACTER ENCORDING
if (!mysqli_set_charset($link, 'utf8'))
{
echo 'Unable to set database connection encoding.';
exit();
}

//SELECT DB
if (!mysqli_select_db($link, 'pi_stats'))

{
$error = 'Unable to locate the raspi stats database.';
echo $error;
exit();
}

//END ERROR HANDELING WITH CONNECITONS
$result = mysqli_query($link, "SELECT AVG(sec) FROM pageload");


// SET ARRAYS
if (!$result)
{
$error = "Error fetching jokes: " . mysqli_error($link);
echo $error;
exit();
}
while ($row = mysqli_fetch_array($result))
{
$guide[] = array('sec' =>$row['AVG(sec)']);
}
//QUERY FOR DISPLAYING DATA # 222222
//END ERROR HANDELING WITH CONNECITONS
$result = mysqli_query($link, "SELECT AVG(temp) FROM temp");


// SET ARRAYS
if (!$result)
{
$error = "Error fetching jokes: " . mysqli_error($link);
echo $error;
exit();
}
while ($row = mysqli_fetch_array($result))
{
$tempz[] = array('temp' =>$row['AVG(temp)']);
}
//QUERY FOR DISPLAYING DATA



////GET BROWSER AND OS DATA

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();


?>

