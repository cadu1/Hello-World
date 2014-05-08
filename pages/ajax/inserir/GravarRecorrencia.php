<?php
    include("../../lib/connection.php");

    $id = $_POST['id'];
    $nome_remetente = $_POST['nome_remetente'];
    $email_remetente = $_POST['email_remetente'];
    $email_aviso = $_POST['email_aviso'];
    $reenvio_atraso = $_POST['reenvio_atraso'];
    $intervalo_atraso = $_POST['intervalo_atraso'];
    $dias_antes = $_POST['dias_antes'];
    $dia = $_POST['dia'];
    $erro = "";

    if(empty($nome_remetente)) {
        $erro = "Preencha Corretamente o campo Nome do remetente<br />";
    }
    if(empty($email_remetente)) {
        $erro .= "Preencha Corretamente o campo Email do remetente<br />";
    }
    if(empty($email_aviso)) {
        $erro .= "Preencha Corretamente o campo Email que receberá o aviso";
    }

    if(empty($erro)) {    
        $query = mysql_query("UPDATE `config_email` SET `config_email_nome`=$nome_remetente,`config_email_remet`=$email_remetente,`config_email_cc`= $email_aviso,`config_email_dia_ant`=$dias_antes,`config_email_atrasado`=$reenvio_atraso,`config_email_no_dia`=$dia WHERE `config_email_id` = $id");
        
        if($query) {
            echo '1|Gravado com Sucesso';
        } else {
            echo '0|Ocorreu um problemas, tente novamente';
        }
    } else {
        echo "0|$erro";
    }
    exit();
?>