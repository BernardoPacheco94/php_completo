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

public function __construct($login = "", $senha="")
{
    $this->setDesLogin($login);
    $this->setDesSenha($senha);
}


public function findById ($id)
{
    $sql = new sql();

    $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID",array(":ID"=>$id));//retorna um array e salva o array na results

    if (isset($results[0]))//verifica se o array existe (posição 0)
    {
        $this->setData($results[0]);          
    }

}

public function setData($data)
{
    $this->setIdUsuario($data['idusuario']);//seta o id com o indice idusuario que veio pelo array do select
        $this->setDesLogin($data['deslogin']);
        $this->setDesSenha($data['dessenha']);
}

public static function getList()//método estático, pois não há this. Pode ser instanciado junto com o objeto
{
    $sql = new sql;

    return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
}

public static function search($login)//localiza users por uma parte do login
{
    $sql = new sql;

    return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin",array(":SEARCH"=>"%".$login."%"));
    
}

public function login($login, $pass)//valida o acesso
{
    $sql = new sql();

    $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASS",array(":LOGIN"=>$login, ":PASS"=>$pass));//retorna um array e salva o array na results

    if (isset($results[0]))//verifica se o array existe (posição 0)
    {
        $this->setData($results[0]);
          
    } else{
        throw new Exception("Login e/ou senha inválidos");
    }
}

public function insert()
{
    $sql = new sql;

    //insert com procedure (criar a procedure no banco), que retorna do banco o id do usuario inserido.
    $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASS)", array(":LOGIN"=>$this->getDesLogin(), ":PASS"=>$this->getDesSenha()));

    if(isset($results[0]))
    { 
        $this->setData($results[0]);
    }


    
    // $sql->execQuery("INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (:LOGIN, :SENHA)", array(":LOGIN"=>$login, ":SENHA"=>$senha));//Sem procedure, podendo ser static
}

public function update($login, $senha)
{
    $this->setDesLogin($login);
    $this->setDesSenha($senha);

    $sql = new sql;

    $sql->execQuery("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID", array(
        ':LOGIN'=>$this->getDesLogin(),
        ':SENHA'=>$this->getDesSenha(),
        ':ID'=>$this->getIdUsuario(),
    ));
}

public function delete()
{
    $sql = new sql;

    $sql->execQuery("DELETE FROM tb_usuarios WHERE idusuario = :ID",array(":ID"=>$this->getIdUsuario()));

    $this->setData(array(
        'idusuario'=>0,
        'deslogin'=>'',
        'dessenha'=>''
    ));
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