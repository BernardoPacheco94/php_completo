<?php

$filename = "certificado".DIRECTORY_SEPARATOR."certificado.jpg";
$fontFilenameBevan= "fonts".DIRECTORY_SEPARATOR."Bevan".DIRECTORY_SEPARATOR."Bevan-Regular.ttf";
$fontFilenamePlayBall= "fonts".DIRECTORY_SEPARATOR."PlayBall".DIRECTORY_SEPARATOR."Playball-Regular.ttf";
$img = imagecreatefromjpeg($filename);

$titleColor = imagecolorallocate($img, 0, 0, 0);

$grey = imagecolorallocate($img, 100, 100, 100);

imagettftext($img, 32, 0, 320, 250, $grey, $fontFilenameBevan, "BEVAN");

imagettftext($img, 32, 0, 375, 150, $grey, $fontFilenamePlayBall, "PLAYBALL");

imagestring($img, 3, 440, 170, utf8_decode("Concluído em: ".date("d/m/Y")), $titleColor);

header("Content-type: image/jpeg");

imagejpeg($img);

imagedestroy($img);

