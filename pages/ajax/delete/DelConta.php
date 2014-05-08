<?php
    include("../../lib/connection.php");
    
    $id = $_POST['conta'];
    
    if($id) {
        $query = mysql_query("DELETE FROM `conta_corrente` WHERE `caixa_id` = $id");
        $query = mysql_query("DELETE FROM `lancamento` WHERE `caixa_id` = $id AND `categoria_id` = 1");
        $query = mysql_query("DELETE FROM `caixa` WHERE `caixa_id` = $id");
    
        if($query) {
            echo '1|Exclu&iacute;do com sucesso';
        } else {
            echo '0|Problemas ao remover item da tabela';
        }
    }
    
    exit();
?>