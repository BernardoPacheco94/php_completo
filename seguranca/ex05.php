<?php

session_start();


//após verificar login e senha, reinicie o di da sessao
session_destroy();
session_start();

session_regenerate_id();

echo session_id();

