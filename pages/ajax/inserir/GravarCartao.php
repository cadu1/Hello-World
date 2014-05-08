<?php
    include("../../lib/connection.php");

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
    $dia_vencimento = $_POST['dia_vencimento'];
    $dia_limite = $_POST['dia_limite'];
    $mes_inicio_fatura = $_POST['mes_inicio_fatura'];
    $ano_inicio_fatura = $_POST['ano_inicio_fatura'];
    $numero_cartao = $_POST['numero_cartao'];
    $conta_cartao = empty($_POST['conta_cartao']) ? "NULL" : $_POST['conta_cartao'];

    $limite = str_replace(".", "", $_POST['limite']);
    $limite = str_replace(",", ".", $limite);
    $limite = empty($limite) ? "0.00" : $limite;

    $erro = "";
//A data de início das faturas não pode ser maior que a data de vencimento
    if(empty($nome)) {
        $erro .= "Preencha corretamente o campo Nome<br />";
    }
    if(empty($mes)) {
        $erro .= "Preencha corretamente o campo M&ecirc;s<br />";
    }
    if(empty($dia_vencimento)) {
        $erro .= "Preencha corretamente o campo Dia do Vencimento<br />";
    }
    if(empty($limite)) {
        $erro .= "Preencha corretamente o campo Limite<br />";
    }
    if(empty($dia_limite)) {
        $erro .= "Preencha corretamente o Dia limite da compra<br />";
    }
    if(empty($erro) && date("Y-m", strtotime($ano_inicio_fatura . "-" . $mes_inicio_fatura)) > date("Y-m", strtotime($ano . "-" . $mes))) {
        $erro .= "A data de início das faturas não pode ser maior que a data de vencimento<br />";
    }
    if(empty($erro)) {
        if(empty($id)){
            $query = mysql_query("INSERT INTO `cartao_credito` VALUES(NULL, $conta_cartao, '$nome', '$numero_cartao', $limite, $mes, $ano, $dia_limite, $dia_vencimento, $mes_inicio_fatura,$ano_inicio_fatura, {$_COOKIE['id']})");
            if($query) {
                echo '1|Cart&atilde;o gravada com Sucesso';
            } else {
                echo '0|Problemas ao gravar';
            }
        } else {
            $query = mysql_query("UPDATE `cartao_credito` SET `cartao_credito_nome`='$nome',`cartao_credito_numero`='$numero_cartao',`cartao_credito_limite`=$limite,`cartao_credito_mes_val`=$mes,`cartao_credito_ano_val`=$ano,`cartao_credito_dia_limite`=$dia_limite,`cartao_credito_dia_fat`=$dia_limite WHERE `cartao_credito_id` = $id"); 

            if($query) {
                echo '1|Cart&atilde;o alterada com Sucesso';
            } else {
                echo '0|Problemas ao realizar alteração';
            }
        }
    } else {
        echo "0|$erro";
    }
    exit();
?>