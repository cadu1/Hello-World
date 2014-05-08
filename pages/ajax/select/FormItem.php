<?php
    include("../../lib/connection.php");
    
    $id = $_POST["item"];
    
    //1|Produto 1|10,00|produto|100,00
    $produtos = mysql_query("SELECT * FROM `produto` WHERE `produto_id` = $id");
    $resp = "";
    
    if(mysql_num_rows($produtos) > 0) {
        while($prod = mysql_fetch_array($produtos)) {
            $resp .= "1|" . $prod['produto_nome'] . "|" . str_replace(".", ",", $prod['produto_vl_venda']) . "|" . 'produto' . "|" . str_replace(".", ",", $prod['produto_ipi']) . "\n"; 
        }
    } else {
        $resp = "0|Ocorreu um erro!";
    }
    
    print($resp);
    exit();
?>