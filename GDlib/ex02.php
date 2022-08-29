<?php

$filename = "certificado".DIRECTORY_SEPARATOR."certificado.jpg";
$img = imagecreatefromjpeg($filename);

$titleColor = imagecolorallocate($img, 0, 0, 0);

$grey = imagecolorallocate($img, 100, 100, 100);

imagestring($img, 5, 450, 150, "CERTIFICADO", $titleColor);
imagestring($img, 5, 440, 350, "Bernardo Pacheco", $titleColor);
imagestring($img, 3, 440, 170, utf8_decode("Concluído em: ".date("d/m/Y")), $titleColor);

header("Content-type: image/jpeg");

imagejpeg($img, "certificado-".date("Y-m-d").".jpg", 10);

imagedestroy($img);

