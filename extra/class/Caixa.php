
<?php

class Caixa
{
    private $id;
    private $comandas;
    private $dataAbertura;
    private $dataFechamento;
    private $valorInicial;
    private $valorFinal;
    private $valorDinheiro;
    private $valorCartaoCredito;
    private $valorCartaoDebito;
    private $valorPix;
    private $sangria;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function getComandas()
    {
        return $this->comandas;
    }

    public function getDataAbertura()
    {
        return $this->dataAbertura;
    }

    public function getDataFechamento()
    {
        return $this->dataFechamento;
    }

    public function getValorInicial()
    {
        return $this->valorInicial;
    }

    public function getValorFinal()
    {
        return $this->valorFinal;
    }

    public function getValorDinheiro()
    {
        return $this->valorDinheiro;
    }

    public function getValorCartaoCredito()
    {
        return $this->valorCartaoCredito;
    }

    public function getValorCartaoDebito()
    {
        return $this->valorCartaoDebito;
    }

    public function getValorPix()
    {
        return $this->valorPix;
    }

    public function getSangria()
    {
        return $this->sangria;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setComandas($comandas)
    {
        $this->comandas = $comandas;
    }

    public function setDataAbertura($dataAbertura)
    {
        $this->dataAbertura = $dataAbertura;
    }

    public function setDataFechamento($dataFechamento)
    {
        $this->dataFechamento = $dataFechamento;
    }

    public function setValorInicial($valorInicial)
    {
        $this->valorFinal = $valorInicial;
    }

    public function setValorFinal($valorFinal)
    {
        $this->valorFinal = $valorFinal;
    }

    public function setValorDinheiro($valorDinheiro)
    {
        $this->valorDinheiro = $valorDinheiro;
    }

    public function setValorCartaoCredito($valorCartaoCredito)
    {
        $this->valorCartaoCredito = $valorCartaoCredito;
    }

    public function setValorCartaoDebito($valorCartaoDebito)
    {
        $this->valorCartaoDebito = $valorCartaoDebito;
    }

    public function setValorPix($valorPix)
    {
        $this->valorPix=$valorPix;
    }

    public function setSangria($sangria)
    {
        $this->sangria=$sangria;
    }

    public function setStatus($status)
    {
        $this->status=$status;
    }

    //  -abertura
	// 	-recebimento de comandas
	// 	-encerramento de comandas
	// 	-receber pagamento
	// 	-alterar-comanda
	// 	-exibir-valores
	// 	-fechamento
}
