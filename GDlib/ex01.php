<?php

header("Content-type: image/png");

$name = "Bernardo";

$img = imagecreate(256, 256);

$black = imagecolorallocate($img, 0, 0, 0);

$red = imagecolorallocate($img, 255, 0, 0);

$blue = imagecolorallocate($img, 0, 0, 255);

imagestring($img, 5, 60, 120, "Ola image - $name", $blue);

imagepng($img);

imagedestroy($img);
