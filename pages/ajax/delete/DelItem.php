<?php
    include("../../lib/connection.php");
    
    $id = $_POST['id'];
    
    $query = mysql_query("DELETE FROM `itens_temporario` WHERE usuario_id = {$_COOKIE['id']} AND produto_id = $id");
    
    if($query) {
        $query = mysql_query("SELECT SUM(`itens_temporario_vl`) AS total FROM `itens_temporario` WHERE usuario_id = $id");
        $result = mysql_fetch_array($query);
        
        echo '1|Exclu&iacute;do com sucesso, clique em salvar para n&atilde;o perder as novas informa&ccedil;&otilde;es|'.str_replace(".", ",", $result['total']);
    } else {
        echo '0|Problemas ao remover item na tabela';
    }
    
    exit();
?>