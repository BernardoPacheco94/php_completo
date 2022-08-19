<?php

require_once "Model.php";

class Anotacao {//extends Model{
    
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

    }

    // public function loadById($idaAnotacao){
    //     $sql = new sql;

    //     $response = $sql->select("SELECT * FROM tb_anotacoes WHERE idanotacao = :IDANOTACAO",array(":IDANOTACAO"=>$idaAnotacao));

    //     $this->setData($response[0]);

    // }

    public function updateAnotacao($titulo='', $conteudo='', $id){

        $sql = new sql;
        
        $sql->execQuery("UPDATE tb_anotacoes SET titulo = :TITULO, conteudo = :CONTEUDO WHERE idanotacao = :IDANOTACAO",array(
            ':TITULO'=>$titulo,
            ':CONTEUDO'=>$conteudo,
            ':IDANOTACAO'=> $id
        ));
    }

    public function deleteAnotacao($idAnotacao)
    {
        $sql = new sql;
        $sql->execQuery("DELETE FROM tb_anotacoes WHERE idanotacao = :ID", array(":ID" => $idAnotacao));        
    }
}

?>