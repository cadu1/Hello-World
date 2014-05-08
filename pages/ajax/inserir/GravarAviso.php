<?php
    include("../../lib/connection.php");

    $id = $_POST['id'];
    $periodo = $_POST['aviso_periodo'];
    $semana = json_decode($_POST['dias_semana']);
    $usuario = json_decode($_POST['usuarios_aviso']);

    if(!empty($semana) && !empty($usuario)) {
        if(!empty($id)) {
            $query = mysql_query("UPDATE `config_notifica` SET `config_notifica_periodo` = '$periodo'");
            
            if($query) {
                mysql_query("DELETE FROM `notifica_semana`");
                mysql_query("DELETE FROM `notifica_usuario`");
                
                foreach($semana as $sem) {
                    mysql_query("INSERT INTO `notifica_semana` VALUES ($id, $sem)");
                }
                foreach($usuario as $usu) {
                    mysql_query("INSERT INTO `notifica_usuario` VALUES ($id, $usu)");
                }
                
                echo '1|Alterado com Sucesso';
            } else {
                echo '0|Problemas ao realizar alteração';
            }
        } else {
            echo '0|Ocorreu um erro entre em contato com o administrador do sistema';
        }
    } else {
        mysql_query("DELETE FROM `notifica_semana`");
        mysql_query("DELETE FROM `notifica_usuario`");
        
        $erro = "";
        if(empty($semana))
            echo "0|Selecione os dias da semana para o envio dos e-mails";
        elseif(empty($usuario))
            echo "0|Selecione os usuário que receberam os e-emails";
    }
    exit();
?>