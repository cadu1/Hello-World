<?php
    include("../../lib/connection.php");

    $conta = $_POST['conta'];
    $nome = $_POST['nome'];
    
    $saldo = str_replace(".", "", $_POST['saldo']);
    $saldo = str_replace(",", ".", $saldo);
    $saldo = empty($saldo) ? "0.00": $saldo;
    
    $data = $_POST['data'];
    $data = str_replace("/", "-", $data);
    $data = date("Y-m-d", strtotime($data));
    $erro = "";

    if(empty($nome)) {
        $erro .= "Preencha corretamente o campo Nome<br />";
    }
    if(empty($data)) {
        $erro .= "Preencha corretamente o campo Data";
    }
    if(empty($erro)) {
        if(empty($conta)){
            $query = mysql_query("INSERT INTO `caixa` VALUES(NULL, {$_COOKIE['id']}, '$nome')");
            
            if($query) {
                $id = mysql_insert_id();

                mysql_query("INSERT INTO `lancamento` (`lancamento_id`, `categoria_id`, `caixa_id`, `lancamento_descricao`, `lancamento_valor`, `lancamento_vencimento`, `lancamento_pago`) VALUES (NULL, 1, $id, 'Saldo Inicial', $saldo, '$data', 1)");
                
                echo '1|Caixa gravada com Sucesso';
            } else {
                echo '0|Problemas ao gravar';
            }
        } else {
            $query = mysql_query("UPDATE `caixa` SET `caixa_nome` = '$nome' WHERE `caixa_id` = $conta"); 

            if($query) {
                mysql_query("UPDATE `lancamento` SET `lancamento_valor`=$saldo, `lancamento_vencimento`='$data' WHERE `caixa_id` = $conta AND `categoria_id` = 1");

                echo '1|Conta alterada com Sucesso|' . date("d/m/Y");
            } else {
                echo '0|Problemas ao realizar alteração';
            }
        }
    } else {
        echo "0|$erro";
    }
    exit();
?>