<?php
require_once 'Cartao.php';

$idBandeira   = $_POST['id_bandeira'];
$numeroCartao = $_POST['numero_cartao'];

switch ($idBandeira)
{
    case ID_BANDEIRA_AMEX_CLASSE_CARTOES :
        $Cartao = new CartaoAmex();
        break;
    case ID_BANDEIRA_AURA_CLASSE_CARTOES :
        $Cartao = new CartaoAura();
        break;
    case ID_BANDEIRA_DINERS_CLASSE_CARTOES :
        $Cartao = new CartaoDiners();
        break;
    case ID_BANDEIRA_DISCOVER_CLASSE_CARTOES :
        $Cartao = new CartaoDiscover();
        break;
    case ID_BANDEIRA_ELO_CLASSE_CARTOES :
        $Cartao = new CartaoELO();
        break;
    case ID_BANDEIRA_HIPERCARD_CLASSE_CARTOES :
        $Cartao = new CartaoHipercard();
        break;
    case ID_BANDEIRA_JCB_CLASSE_CARTOES :
        $Cartao = new CartaoJCB();
        break;
    case ID_BANDEIRA_MASTERCARD_CLASSE_CARTOES :
        $Cartao = new CartaoMasterCard();
        break;
    case ID_BANDEIRA_VISA_CLASSE_CARTOES :
        $Cartao = new CartaoVisa();
        break;
    default :
        die ("Ajax Valida Cartao: O ID da bandeira do cartao foi informado incorretamente.");;
        break;
}

$Cartao->setNumeroCartao($numeroCartao);

if ($Cartao->validar())
{
    print 1;
}
else
{
    print 0;
}

?>