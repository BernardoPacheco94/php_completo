<?php



if (!is_dir("images")) mkdir("images");

foreach (scandir("images") as $img) {
    if(!in_array($img, array(".",".."))){
        unlink("images/$img");
    }
}  

echo "itens removidos";


