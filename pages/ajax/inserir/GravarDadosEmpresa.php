<?php
    include("../../lib/connection.php");
    
    $CNPJ = $_POST['cnpj'];
    $razao = $_POST['razao'];
    
    function validaCnpj($cnpj) {
        $cnpj = trim($cnpj);
        $soma = 0;
        $multiplicador = 0;
        $multiplo = 0;
       
        # [^0-9]: RETIRA TUDO QUE NÃO É NUMÉRICO,  "^" ISTO NEGA A SUBSTITUIÇÃO, OU SEJA, SUBSTITUA TUDO QUE FOR DIFERENTE DE 0-9 POR "";
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if(empty($cnpj) || strlen($cnpj) != 14) 
            return FALSE;
    
        # VERIFICAÇÃO DE VALORES REPETIDOS NO CNPJ DE 0 A 9 (EX. '00000000000000')    
        for($i = 0; $i <= 9; $i++) {
            $repetidos = str_pad('', 14, $i);
           
            if($cnpj === $repetidos)
                return FALSE;
        }
       
        # PEGA A PRIMEIRA PARTE DO CNPJ, SEM OS DÍGITOS VERIFICADORES    
        $parte1 = substr($cnpj, 0, 12);   
       
        # INVERTE A 1ª PARTE DO CNPJ PARA CONTINUAR A VALIDAÇÃO    
        $parte1_invertida = strrev($parte1);
       
        # PERCORRENDO A PARTE INVERTIDA PARA OBTER O FATOR DE CALCULO DO 1º DÍGITO VERIFICADOR
        for ($i = 0; $i <= 11; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;
            $multiplo = ($parte1_invertida[$i] * $multiplicador);
            $soma += $multiplo;
            $multiplicador++;
        }
       
        # OBTENDO O 1º DÍGITO VERIFICADOR        
        $rest = $soma % 11;
       
        $dv1 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;
           
        # PEGA A PRIMEIRA PARTE DO CNPJ CONCATENANDO COM O 1º DÍGITO OBTIDO 
        $parte1 .= $dv1;
       
        # MAIS UMA VEZ INVERTE A 1ª PARTE DO CNPJ PARA CONTINUAR A VALIDAÇÃO 
        $parte1_invertida = strrev($parte1);
           
        $soma = 0;
       
        # MAIS UMA VEZ PERCORRE A PARTE INVERTIDA PARA OBTER O FATOR DE CALCULO DO 2º DÍGITO VERIFICADOR       
        for ($i = 0; $i <= 12; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;
            $multiplo = ($parte1_invertida[$i] * $multiplicador);
            $soma += $multiplo;
            $multiplicador++;
        }
           
        # OBTENDO O 2º DÍGITO VERIFICADOR
        $rest = $soma % 11;
       
        $dv2 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;
        # AO FINAL COMPARA SE OS DÍGITOS OBTIDOS SÃO IGUAIS AOS INFORMADOS (OU A SEGUNDA PARTE DO CNPJ)   
        return ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) ? TRUE : FALSE;
        //echo ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) ? 'TRUE' : 'FALSE';} 
    }
    
    
    if(empty($CNPJ) || empty($razao)) {
        echo "0|Informe uma Raz&atilde;o Social e um CNPJ v&aacute;lido!";
    } else {
		if(!validaCnpj($CNPJ)) {
            echo "0|CNPJ inv&aacute;lido";
		} else {
            $query = mysql_query("UPDATE `config_financ` SET `config_financ_raz_social` = '$razao', `config_financ_cnpj` = '$CNPJ'");
            if($query) {
                echo "1|Dados alterados com sucesso!";
            } else {
                echo "0|Problemas ao realizar esta altera&ccedil;&atilde;o!";
            }
		}
    }
    exit();
?>