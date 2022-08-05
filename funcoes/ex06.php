<?php

function soma(int ...$valores){//o tipo é opcional
    return array_sum($valores);
}

echo soma(30, 2.65, 64);