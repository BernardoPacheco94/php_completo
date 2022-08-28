<?php

// function error_handler($code, $message, $file, $line)
// {
//     echo json_encode(array(
//         "code" => $code,
//         "message" => $message,
//         "file" => $file,
//         "line" => $line
//     ));
// }

// set_error_handler("error_handler");

// echo 100/0;


try {
    echo 100 / 0;
} catch (\Throwable $th) {
    echo json_encode(
        array(
            "code"=>$th->getCode(),
            "message"=>$th->getMessage(),
            "file"=>$th->getFile(),
            "line"=>$th->getLine()
        ),JSON_UNESCAPED_SLASHES
    );
}