<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class Address extends Model
{
    const SESSION_ERROR = "AddressError";

    public static function getCEP($nrZipcode)    
    {
        //https://viacep.com.br/ws/97050700/json/
        $nrZipcode = str_replace('-','',$nrZipcode);
        $nrZipcode = str_replace('.','',$nrZipcode);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://viacep.com.br/ws/$nrZipcode/json/");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $data;        
    }

    public function loadFromCEP($nrZipcode)
    {
        $data = Address::getCEP($nrZipcode);

        if(isset($data['logradouro']) && $data['logradouro'])
        {
            $this->setdesaddress($data['logradouro']);
            $this->setdescomplement($data['complemento']);
            $this->setdesdistrict($data['bairro']);
            $this->setdescity($data['localidade']);
            $this->setdesstate($data['uf']);
            $this->setdescountry('Brasil');
            $this->setdeszipcode($nrZipcode);
        }
    }

    public function save()
    {
        $sql = new Sql;

        $result = $sql->select('CALL sp_addresses_save (:idaddress, :idperson, :desaddress, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)',[
            'idaddress'=>$this->getidaddress(),
            'idperson'=>$this->getidperson(),
            'desaddress'=>$this->getdesaddress(),
            'descomplement'=>$this->getdescomplement(),
            'descity'=>$this->getdescity(),
            'desstate'=>$this->getdesstate(),
            'descountry'=>$this->getdescountry(),
            'deszipcode'=>$this->getdeszipcode(),
            'desdistrict'=>$this->getdesdistrict()
        ]);

        if(count($result) > 0)
        {
            $this->setData($result[0]);
        }

    }

    
    public static function setMsgError($msg)//sessao para passar a mensagem de erro no calculo do frete, caso exista
    {
        $_SESSION[Address::SESSION_ERROR] = (string)$msg;        
    }

    public static function getMsgError()
    {
        $msg = (isset($_SESSION[Address::SESSION_ERROR])) ? $_SESSION[Address::SESSION_ERROR] : "";
        Address::clearMsgError();
       
        return $msg;
    }

    public static function clearMsgError()
    {
        $_SESSION[Address::SESSION_ERROR] = NULL;
    }
}
