<?php

function ola(){
    return func_get_args();
}

var_dump(ola('Bom dia', 10));