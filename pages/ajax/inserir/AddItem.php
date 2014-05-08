<?php
    include("../../lib/connection.php");
    
    $id = $_POST['item'];
    $qtd = $_POST['qtd'];
    $valor = $_POST['valor'];
    $valor = str_replace(",", ".", $valor);
    
    $query = mysql_query("SELECT * FROM `itens_temporario` WHERE `usuario_id` = {$_COOKIE['id']} AND `produto_id` = $id");
    
    if(mysql_num_rows($query) == 0) {
        $query = mysql_query("INSERT INTO `itens_temporario` VALUES ({$_COOKIE['id']}, $id, $qtd, $valor)");
        
        if($query) {
            $query = mysql_query("SELECT SUM(`itens_temporario_vl`) AS total FROM `itens_temporario` WHERE usuario_id = {$_COOKIE['id']}");
            $result = mysql_fetch_array($query);
            
            echo '1|Adicionado com sucesso, clique em salvar para n&atilde;o perder as novas informa&ccedil;&otilde;es|'.str_replace(".", ",", $result['total']);
        } else {
            echo '0|Problemas ao gravar o item na tabela';
        }
    } else {
        echo '0|Este produto/servi&ccedil;o j&aacute; foi adicionado, por favor selecione outro';
    }
    exit();
?>