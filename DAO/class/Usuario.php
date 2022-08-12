<?php

class Usuario
{
    private $idusuario;
    private $deslogin;
    private $dessenha;


public function getIdUsuario()
{
    return $this->idusuario;
}

public function setIdUsuario($value)
{
    $this->idusuario = $value;
}

public function getDesLogin()
{
    return $this->deslogin;
}

public function setDesLogin($value)
{
    $this->deslogin=$value;
}

public function getDesSenha()
{
    return $this->dessenha;
}

public function setDesSenha($value)
{
    $this->dessenha=$value;
}


public function findById ($id)
{
    $sql = new sql();

    $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",array(":ID"=>$id));//retorna um array e salva o array na results

    if (isset($results[0]))//verifica se o array existe (posição 0)
    {
        $row = $results[0];//joga o array na varável $row


        $this->setIdUsuario($row['idusuario']);//seta o id com o indice idusuario que veio pelo array do select
        $this->setDesLogin($row['deslogin']);
        $this->setDesSenha($row['dessenha']);
          
    }

}

public function __toString()
{
    return json_encode(array(
        "Usuario"=>$this->getIdUsuario(),
        "Login"=>$this->getDesLogin(),
        "Senha"=>$this->getDesSenha()
    ));    
}

}