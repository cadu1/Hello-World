<?php
    include("../../lib/connection.php");
    
    $id = $_POST['centro'];
    $nome = $_POST['nome'];    
    $erro = "";
    
    if(empty($nome)) {
        $erro = "Preencha corretamente o campo nome";
    }
    if(empty($erro)) {
        if(empty($id)) {
            $query = mysql_query("INSERT INTO `centro_custo` VALUES (NULL, '$nome', {$_COOKIE['id']})");
        } else {
            $query = mysql_query("UPDATE `centro_custo` SET `centro_custo_nome` = '$nome' WHERE `centro_custo_id` = $id");
        }
        
        if($query){
           echo "1|Gravado com Sucesso!";
        } else {
            echo "0|Problemas ao gravar, tente novamente";
        }
    } else {
        echo "0|$erro";
    }
    
    exit();
?>