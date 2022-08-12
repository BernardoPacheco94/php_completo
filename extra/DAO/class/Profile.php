<?php

class Profile
{
    private $idprofile;
    private $nome;
    private $idade;
    private $genero;

    public function getIdProfile()
    {
        return $this->idprofile;
    }
    public function setIdProfile($value)
    {
        $this->idprofile = $value;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($value)
    {
        $this->nome = $value;
    }

    public function getIdade()
    {
        return $this->idade;
    }

    public function setIdade($value)
    {
        $this->idade = $value;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function setGenero($value)
    {
        $this->genero = $value;
    }

    public function loadById($id)
    {
        $acess = new Access;

        $resp = $acess->select("SELECT * FROM tb_profile WHERE idprofile = :ID",array(":ID"=>$id));

        if (isset($resp[0]))
        {
            $row = $resp[0];

            $this->setIdProfile($row['idprofile']);
            $this->setNome($row['nome']);
            $this->setIdade($row['idade']);
            $this->setGenero($row['genero']);
        }
    }

    public function __toString()
    {
        return json_encode(array(
            "Id:"=>$this->getIdProfile(),
            "Nome:"=>$this->getNome(),
            "Idade:"=>$this->getIdade(),
            "Genero:"=>$this->getGenero(),
        ));
    }
}