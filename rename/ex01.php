<?php

$dir01 = "folder01";
$dir02 = "folder02";

if(!is_dir($dir01)) mkdir($dir01);

if(!is_dir($dir02)) mkdir($dir02);


$filename = "README.txt";
if (!file_exists($dir01.DIRECTORY_SEPARATOR.$filename))
{
    $file = fopen($dir01.DIRECTORY_SEPARATOR.$filename, "w+");
    fwrite($file, date("d/m/Y H:i:s"));
    fclose($file);
}

rename($dir01.DIRECTORY_SEPARATOR.$filename, 
$dir02.DIRECTORY_SEPARATOR.$filename);
