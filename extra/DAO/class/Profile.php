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

    public static function listProfiles()
    {
        $access = new Access;
        $str = $access->select("SELECT * FROM tb_profile ORDER BY nome");

        return json_encode($str);
    }

    public function loadById($id)
    {
        $acess = new Access;

        $resp = $acess->select("SELECT * FROM tb_profile WHERE idprofile = :ID", array(":ID" => $id));

        if (isset($resp[0])) {
            $row = $resp[0];

            $this->setIdProfile($row['idprofile']);
            $this->setNome($row['nome']);
            $this->setIdade($row['idade']);
            $this->setGenero($row['genero']);
        }
    }

    public static function searchProfile($nome)
    {
        $access = new Access;

        $search = $access->select("SELECT * FROM tb_profile WHERE nome LIKE :SEARCHPROFILE ORDER BY nome", array(":SEARCHPROFILE" => "%" . $nome . "%"));

        return json_encode($search);
    }



    public function insert($nome, $idade, $genero)
    {
        $access = new Access;
        $access->execQuery("INSERT INTO tb_profile (nome, idade, genero) VALUES (:NOME, :IDADE, :GENERO)", array(":NOME" => $nome, ":IDADE" => $idade, ":GENERO" => $genero));
    }

    public function update($nome = '', $idade = '', $genero = '') //passar apenas o que vai ser alterado, pois o id já deve estar carregado, inicializar as variáeis em branco para que não de erro caso nao sejam passadas
    {
        $this->setNome($nome);
        $this->setIdade($idade);
        $this->setGenero($genero);

        $access = new Access;
        $access->execQuery(
            "UPDATE tb_profile SET nome = :NOME, idade = :IDADE, genero = :GENERO WHERE idprofile = :ID",
            array(
                ':NOME' => $this->getNome(),
                'IDADE' => $this->getIdade(),
                'GENERO' => $this->getGenero(),
                ':ID' => $this->getIdProfile()
            )
        );
    }

    public function delete()
    {
        $access = new Access;
        $access->execQuery("DELETE FROM tb_profile WHERE idprofile = :ID", array(":ID" => $this->getIdProfile()));

        $this->setIdProfile('');
        $this->setNome('');
        $this->setIdade(null);
        $this->setGenero('');
    }

    public function __toString()
    {
        return json_encode(array(
            "Id:" => $this->getIdProfile(),
            "Nome:" => $this->getNome(),
            "Idade:" => $this->getIdade(),
            "Genero:" => $this->getGenero(),
        ));
    }
}
