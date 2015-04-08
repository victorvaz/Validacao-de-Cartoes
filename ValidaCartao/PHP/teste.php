<?php
    require_once 'Cartoes.php';
 ?>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript" src="jquery.js"></script>
        <title></title>
        <script>
            function validaCartao()
            {
                $.post(
                    'ajax_valida_cartao.php',
                    {
                        numero_cartao: $("#num_cartao").val(),
                        id_bandeira: $("#bandeira_cartao").val()
                    },
                    function(retorno)
                    {
                        if (retorno == "1")
                        {
                            $("#resposta").html("Este cartão é válido.");
                        }
                        else
                        {
                            $("#resposta").html("Este cartão não é válido.");
                        }
                    }
                );
            }
        </script>
    </head>
    <body>
        Numero do Cartao:
        <input type="text" id="num_cartao" /><br />
        Bandeira do Cartao:
        <select id="bandeira_cartao">
            <option value="<?php print ID_BANDEIRA_AMEX_CLASSE_CARTOES; ?>">AMEX</option>
            <option value="<?php print ID_BANDEIRA_AURA_CLASSE_CARTOES; ?>">AURA</option>
            <option value="<?php print ID_BANDEIRA_DINERS_CLASSE_CARTOES; ?>">DINERS</option>
            <option value="<?php print ID_BANDEIRA_DISCOVER_CLASSE_CARTOES; ?>">DISCOVER</option>
            <option value="<?php print ID_BANDEIRA_ELO_CLASSE_CARTOES; ?>">ELO</option>
            <option value="<?php print ID_BANDEIRA_HIPERCARD_CLASSE_CARTOES; ?>">HIPERCARD</option>
            <option value="<?php print ID_BANDEIRA_JCB_CLASSE_CARTOES; ?>">JCB</option>
            <option value="<?php print ID_BANDEIRA_MASTERCARD_CLASSE_CARTOES; ?>">MASTERCARD</option>
            <option value="<?php print ID_BANDEIRA_VISA_CLASSE_CARTOES; ?>">VISA</option>
        </select><br />
        <input type="button" onclick="validaCartao();" value="Verifica Validação" />
        <div id="resposta"></div>
    </body>
</html>
