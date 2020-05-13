
<?php 
  
  // Load an image from jpeg URL 
  $im = imagecreatefromjpeg( 
  'https://media.geeksforgeeks.org/wp-content/uploads/20200123100652/geeksforgeeks12.jpg'); 
    
  // View the loaded image in browser using imagejpeg() function 
  header('Content-type: image/jpg');   
  // Decrease the quality of image to 2 
  imagejpeg($im, null, 2); 
  imagedestroy($im); 
  ?> 
  