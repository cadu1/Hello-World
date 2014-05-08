<?php
    include("../../lib/connection.php");
    
    $id = $_POST['id'];
    
    if($id) {
        $query = mysql_query("DELETE FROM `cartao_credito` WHERE `cartao_credito_id` = $id");
    
        if($query) {
            echo '1|Exclu&iacute;do com sucesso';
        } else {
            echo '0|Problemas ao remover item da tabela';
        }
    }
    
    exit();
?>