<?php
/*

 +============================================================================+
 | Classe Cartões                                                             |
 +----------------------------------------------------------------------------+
 | Autor: Victor Vaz de Oliveira                                              |
 | Data : 16/12/2013                                                          |
 +----------------------------------------------------------------------------+
 
*/

/**
 * Define as constantes referentes a esta classe.
 */
define("ID_BANDEIRA_AMEX_CLASSE_CARTOES",       1);
define("ID_BANDEIRA_AURA_CLASSE_CARTOES",       2);
define("ID_BANDEIRA_DINERS_CLASSE_CARTOES",     3);
define("ID_BANDEIRA_DISCOVER_CLASSE_CARTOES",   4);
define("ID_BANDEIRA_ELO_CLASSE_CARTOES",        5);
define("ID_BANDEIRA_HIPERCARD_CLASSE_CARTOES",  6);
define("ID_BANDEIRA_JCB_CLASSE_CARTOES",        7);
define("ID_BANDEIRA_MASTERCARD_CLASSE_CARTOES", 8);
define("ID_BANDEIRA_VISA_CLASSE_CARTOES",       9);

/**
 * Classe com métodos referentes a Cartões.
 * @author Víctor Vaz <victor.vaz@hotmail.com>
 * @date 16/12/2013
 */
class Cartao
{
    private $_numeroCartao;
       
    /**
     * Guarda o número do cartão.
     * @param int $numeroCartao Número do Cartão.
     */
    public function setNumeroCartao($numeroCartao)
    {       
        $this->_numeroCartao = $numeroCartao;
        $this->_numeroCartao = $this->parseNumeroCartao();
    }
    
    /**
     * Retorna o número do cartão.
     * @return string
     */
    protected function getNumeroCartao()
    {
        return $this->_numeroCartao;
    }
    
    /**
     * Função para validar se o número do cartão é válido.
     * @author Victor Vaz
     * @date 17/12/2013
     * @return boolean
     */
    public function validar()
    {
        if ($this->validarQtdNumeros($dados = $this->getQtdNumeros()) == false)
        {
            return false;
        }
        else if ($this->validarNumerosIniciais($dados = $this->getNumerosIniciais()) == false)
        {
            return false;
        }
        else if ($this->validarPorAlgoritmoLunh() == false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    /**
     * Função para retirar caracteres indesejáveis do numero.
     * @author Victor Vaz
     * @date 16/12/2013
     * @return string
     */
    private function parseNumeroCartao()
    {   
        $numeroCartao = str_replace(" ", "", $this->getNumeroCartao()); // Retira Espaços.
        $numeroCartao = str_replace(".", "", $numeroCartao); // Retira Pontos.
        $numeroCartao = str_replace("-", "", $numeroCartao); // Retira Traços.
        return $numeroCartao;
    }
    
    /**
     * Função para validar se o número do cartão de crédito obedece ao tamanho
     * especificado pela bandeira.
     * @param array $tamanhoMaximo Array contendo as quantidades que o numero pode ter.
     * @author Victor Vaz
     * @date 16/12/2013
     * @return boolean
     */
    protected function validarQtdNumeros($tamanhoMaximo = null)
    {
        if ($tamanhoMaximo == null)
        {
            die("Classe 'Cartoes' [validaQtdNumeros()]: O tamanho maximo nao pode ser NULO.");
            return false;
        }
        
        for ($i = 0; $i < count($tamanhoMaximo); $i++)
        {
            if (strlen($this->getNumeroCartao()) == $tamanhoMaximo[$i])
            {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Verifica se o numero BIN (Bank Information Number) informado no cartão é válido.
     * @param array $inicios Array contendo os valores iniciais do cartao.
     * @return boolean
     */
    protected function validarNumerosIniciais($inicios = null)
    {
        if ($inicios == null)
        {
            die("Classe 'Cartoes' [validaQtdNumeros()]: Os valores iniciais (BIN) nao pode ser NULO.");
            return false;
        }
        
        for ($i = 0; $i < count($inicios); $i++)
        {
            $numeroCartao = $this->getNumeroCartao();
            $qtdNumBIN = strlen($inicios[$i]);            
            $numerosParaVerificar = substr($numeroCartao, 0, $qtdNumBIN);
            
            if ($numerosParaVerificar == $inicios[$i])
            {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Valida o numero por algoritmo.
     * @author Victor Vaz
     * @date 16/12/2013
     * @return boolean
     */
    protected function validarPorAlgoritmoLunh()
    {
        $numeroCartao = $this->getNumeroCartao();
        $qtdNumerosCartao = strlen($numeroCartao);
        $numeros = array();
        $totalSoma = 0;
        
        // Guarda cada número em um índice que será sua posição.
        for ($i = 0; $i < $qtdNumerosCartao; $i++)
        {
            $numeros[$i] = substr($numeroCartao, $i, 1);
        }
        
        for ($i = 0; $i < $qtdNumerosCartao; $i++)
        {
            if ( (($i % 2) == 0) || ($i == 0) )
            {
                $multiplacao = ($numeros[$i] * 2);
                
                if ($multiplacao >= 10)
                {
                    $multiplacao = ($multiplacao - 9);
                }
               
                $numeros[$i] = $multiplacao;
            }
        }
        
        // Guarda cada número em um índice que será sua posição.
        for ($i = 0; $i < $qtdNumerosCartao; $i++)
        {
            $totalSoma += $numeros[$i];
        }
        
        if ($totalSoma % 10 == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

/**
 * Classe com métodos para cartões de bandeira ELO.
 */
class CartaoELO extends Cartao
{
    private $_qtdNumeros = array(16);
    private $_numerosIniciais = array(636368,438935,504175,451416,636297,5067,4576,4011);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira MasterCard.
 */
class CartaoMasterCard extends Cartao
{
    private $_qtdNumeros = array(16);
    private $_numerosIniciais = array(5);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Visa.
 */
class CartaoVisa extends Cartao
{
    private $_qtdNumeros = array(13,16);
    private $_numerosIniciais = array(4);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Diners.
 */
class CartaoDiners extends Cartao
{
    private $_qtdNumeros = array(14,16);
    private $_numerosIniciais = array(301,305,36,38);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Amex.
 */
class CartaoAmex extends Cartao
{
    private $_qtdNumeros = array(15);
    private $_numerosIniciais = array(34,37);
    private $_numeroCVC = 4;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Discover.
 */
class CartaoDiscover extends Cartao
{
    private $_qtdNumeros = array(16);
    private $_numerosIniciais = array(6011,622,64,65);
    private $_numeroCVC = 4;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Aura.
 */
class CartaoAura extends Cartao
{
    private $_qtdNumeros = array(16);
    private $_numerosIniciais = array(50);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira JCB.
 */
class CartaoJCB extends Cartao
{
    private $_qtdNumeros = array(16);
    private $_numerosIniciais = array(35);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}

/**
 * Classe com métodos para cartões de bandeira Hipercard.
 */
class CartaoHipercard extends Cartao
{
    private $_qtdNumeros = array(13,16,19);
    private $_numerosIniciais = array(38,60);
    private $_numeroCVC = 3;
    
    protected function getNumeroCVC(){ return $this->_numeroCVC; }
    protected function getQtdNumeros(){ return $this->_qtdNumeros; }
    protected function getNumerosIniciais(){ return $this->_numerosIniciais; }
}
?>
