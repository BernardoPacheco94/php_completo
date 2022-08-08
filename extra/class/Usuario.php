<?php

//conectar com o banco

class usuarios
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

    public function setAtivo ($ativo)
    {
        $this->ativo = $ativo;
    }

    //métodos de login


}
