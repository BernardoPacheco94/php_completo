<?php

//conectar com o banco

class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $passhash;
    private $ativo;


    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPasshash()
    {
        return $this->passhash;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setId($idusuario)
    {
        $this->id = $idusuario;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPasshash($passhash)
    {
        $this->passhash = $passhash;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public static function listUsuarios()
    {
        $sql = new sql;

        return $sql->select("SELECT * FROM usuarios");        

    }


    public function loadById($id)
    {
        $load = new sql;

        $resultado = $load->select("SELECT * FROM usuarios WHERE idusuario = :ID", array(":ID" => $id)); //passa o load para o OBJETO resultado

        if (isset($resultado[0])) //testa se o obj existe
        {
            $row = $resultado[0]; //passa o obj pra uma variável
            $this->setId($row['idusuario']);
            $this->setEmail($row['email']);
            $this->setPasshash($row['passhash']);
            $this->setNome($row['nome']);
            $this->setAtivo($row['ativo']);
        }

        //echo json_encode($resultado);
    }

    public function login($email, $senha)
    {
        $sql = new sql;//talvez tenha ()
        $resultado = $sql->select("SELECT * FROM usuarios WHERE email = :EMAIL AND passhash = :PASSHASH",array(":EMAIL"=>$email, ":PASSHASH"=>$senha));//retorna array com as info

        $array = $resultado[0];

        $this->setId($array['idusuario']);
        $this->setEmail($array['email']);
        $this->setPasshash($array['passhash']);
        $this->setNome($array['nome']);
        $this->setAtivo($array['ativo']);
        
    }

    public function __toString()
    {
        return json_encode(array(
            "ID" => $this->getId(),
            "Email" => $this->getEmail(),
            "Nome" => $this->getNome(),
            "Ativo" => $this->getAtivo()
        ));
    }
}
