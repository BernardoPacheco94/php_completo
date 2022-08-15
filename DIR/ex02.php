<?php

$images = scandir("images");
$data = array();

//echo json_encode($images);

foreach ($images as $img) {//percorre o array $images setando cada img
    if (!in_array($img, array(".","..")))//ignora o . e ..
    {
        $filename = "images".DIRECTORY_SEPARATOR.$img;

        $info = pathinfo($filename);
        $info["size"] = filesize($filename);
        $info["modified"]=date("d/m/Y H:i:s", filemtime($filename));
        $info["url"]="http://localhost/DIR/".str_replace("\\","/", $filename);

        array_push($data,$info);
    }
}

echo json_encode($data,JSON_UNESCAPED_SLASHES);
