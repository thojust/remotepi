
<?php 
  
  // Load an image from jpeg URL 
 imagecreatefromjpeg( 
  'https://www.thetelegram.com/media/photologue/photos/cache/GS__4_-_rainbow_Brian_Hay_Granville_Ferry_NS_large.jpg'); 
    
  // View the loaded image in browser using imagejpeg() function 
  header('Content-type: image/jpg');   
  // Decrease the quality of image to 2 
  imagejpeg($im); 
 
  ?> 
  