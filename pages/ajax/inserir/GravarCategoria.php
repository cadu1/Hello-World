<?php
    include("../../lib/connection.php");

    $id = $_POST['categoria'];
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'] == 2 ? 0 : 1;
    $pai = empty($_POST['pai']) ? "NULL" : $_POST['pai'];
    $erro = "";

    if(empty($nome)){
        $erro = "Preencha Corretamente o campo nome<br />";
    }

    if(empty($erro)) {
        if(!empty($id)) {
            $query = mysql_query("UPDATE `categoria` SET `id_subcategoria` = $pai, `categoria_nome` = '$nome', `categoria_tipo` = $tipo WHERE `categoria_id` = $id");

            if($query) {
                echo '1|Alterado com Sucesso';
            } else {
                echo '0|Problemas ao realizar altera&ccedil;&atilde;o';
            }
        } else {
            //echo "INSERT INTO `categoria` VALUES (NULL, $pai, '$nome', $tipo, {$_COOKIE['id']})";exit();
            $query = mysql_query("INSERT INTO `categoria` VALUES (NULL, $pai, '$nome', $tipo, {$_COOKIE['id']})");

            if($query) {
                echo '1|Gravado com Sucesso';
            } else {
                echo '0|Ocorreu um erro, tente novamente';
            }
        }
    } else {
        echo "0|$erro";
    }
    exit();
?>