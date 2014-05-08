<?php
    include("../../lib/connection.php");

    $conta = $_POST['conta'];
    $nome = $_POST['nome'];
    $banco = $_POST['banco'];
    $agencia = $_POST['agencia'];
    $numero = $_POST['numero'];
    
    $carteira = empty($_POST['carteira']) ? "null" : $_POST['carteira'];
    $linha1 = $_POST['linha1'];
    $linha2 = $_POST['linha2'];
    $linha3 = $_POST['linha3'];

    $convenio = empty($_POST['convenio']) ? "null" : $_POST['convenio'];
    $tipo_saldo = $_POST['tipo_saldo'];
    $dv_conta = $_POST['dv_conta'];
    $dv_agencia = $_POST['dv_agencia'];
    
    $dv_cedente = empty($_POST['dv_cedente']) ? "null" : $_POST['dv_cedente'];

    $limite = str_replace(".", "", $_POST['limite']);
    $limite = str_replace(",", ".", $limite);
    $limite = empty($limite) ? "0.00" : $limite;

    $saldo = str_replace(".", "", $_POST['saldo']);
    $saldo = str_replace(",", ".", $saldo);
    $saldo = empty($saldo) ? "0.00": $saldo;
    
    $custo = str_replace(".", "", $_POST['custo']);
    $custo = str_replace(",", ".", $custo);
    $custo = empty($custo) ? "0.00": $custo;

    $data = $_POST['data'];
    $data = str_replace("/", "-", $data);
    $data = date("Y-m-d", strtotime($data));
    $erro = "";

    if(empty($nome)) {
        $erro .= "Preencha corretamente o campo Nome<br />";
    }
    if(empty($banco)) {
        $erro .= "Preencha corretamente o campo Banco<br />";
    }
    if(empty($agencia)) {
        $erro .= "Preencha corretamente o campo Agência<br />";
    }
    if(empty($numero)) {
        $erro .= "Preencha corretamente o campo Número<br />";
    }
    if(empty($dv_conta)) {
        $erro .= "Preencha corretamente o campo Dv Conta<br />";
    }
    if(empty($data)) {
        $erro .= "Preencha corretamente o campo Data";
    }
    if(empty($erro)) {
        if(empty($conta)){
            $query = mysql_query("INSERT INTO `caixa` VALUES(NULL, {$_COOKIE['id']}, '$nome')");
            
            if($query) {
                $id = mysql_insert_id();
                mysql_query("INSERT `conta_corrente` VALUES (NULL, $banco, $id, $limite, $agencia, $dv_agencia, $numero, $dv_conta, $carteira, $custo, $convenio, $dv_cedente, '$linha1', '$linha2', '$linha2')");

                mysql_query("INSERT INTO `lancamento` (`lancamento_id`, `categoria_id`, `caixa_id`, `lancamento_descricao`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_pago`) VALUES (NULL, 1, $id, 'Saldo Inicial', $saldo, '$data', 1)");
                
                echo '1|Conta gravada com Sucesso';
            } else {
                echo '0|Problemas ao gravar';
            }
        } else {
            $query = mysql_query("UPDATE `caixa` SET `caixa_nome` = '$nome' WHERE `caixa_id` = $conta"); 

            if($query) {
                mysql_query("UPDATE `conta_corrente` SET `banco_id`=$banco,`conta_corrente_limite`=$limite,`conta_corrente_agencia`=$agencia,`conta_corrente_ag_dv`=$dv_agencia,`conta_corrente_num`=$numero,`conta_corrente_num_dv`=$dv_conta,`conta_corrente_carteira`=$carteira,`conta_corrente_custo`=$custo,`conta_corrente_convenio`=$convenio,`conta_corrente_conv_dv`=$dv_cedente,`conta_corrente_linha1`='$linha1',`conta_corrente_linha2`='$linha2',`conta_corrente_linha3`='$linha2' WHERE `caixa_id` = $conta");

                mysql_query("UPDATE `lancamento` SET `lancamento_valor`=$saldo, `lancamento_vencimento`='$data' WHERE `caixa_id` = $conta AND `categoria_id` = 1");

                echo '1|Conta alterada com Sucesso';
            } else {
                echo '0|Problemas ao realizar alteração';
            }
        }
    } else {
        echo "0|$erro";
    }
    exit();
?>