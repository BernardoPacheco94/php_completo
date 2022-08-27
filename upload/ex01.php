<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>

<body>
    <!-- o enctype informa que enviarei dados binários, permitindo que eu envie arquivos também e não só infos de formulario-->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileUpload" id="file"> 
        <input type="submit" value="Enviar">
    </form>
</body>

</html>


<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $file = $_FILES["fileUpload"];

        if($file["error"])
        {
            throw new Error("Error: ".$file['error']);
        }

        $dirUploads = "uploads";

        if(!is_dir($dirUploads))//se o diretório uploads não existir será criado
        {
            mkdir($dirUploads);
        }

        if(move_uploaded_file($file["tmp_name"], $dirUploads.DIRECTORY_SEPARATOR.$file["name"]))
        {
            echo "Arquivo enviado";
        }
        else{
            throw new Exception('Erro ao enviar arquivo', 1);
        }
    }

?>
