<?php
$imagick = new \Imagick();
$imagick->newImage(100, 100, new \ImagickPixel('red'));
$imagick->setImageFormat('png');
header('Content-Type: image/png');
echo $imagick;
?>