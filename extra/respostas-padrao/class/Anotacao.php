<?php

require_once "Model.php";

class Anotacao extends Model{
    
    public function novaAnotacao($titulo, $conteudo){
        $sessionData = $_SESSION['Usuario'];
        $idUsuario = $sessionData['idusuario'];
        $sql = new sql;
        
        
        $sql->execQuery("INSERT INTO tb_anotacoes (titulo, conteudo, idusuario) VALUES (:TITULO, :CONTEUDO, :IDUSUARIO) ", array(
            ':TITULO'=>$titulo,
            ':CONTEUDO'=>$conteudo,
            ':IDUSUARIO'=>$idUsuario
        ));
        
        header('Location: index.php');
    }
    
    public static function exibeAnotacoes(){
        $sessionData = $_SESSION['Usuario'];
        $idUsuario = $sessionData['idusuario'];
        $sql = new sql;

        return $sql->select("SELECT * FROM tb_anotacoes WHERE idusuario = :IDUSUARIO",array(':IDUSUARIO'=> $idUsuario));

        
        // $anotacoes = new Anotacao;
        // $anotacoes->setData($result);
        

        // return array($anotacoes -> getData());
    }
}

?>