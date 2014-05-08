<?php
    include("../../lib/connection.php");

    if(isset($_GET['term'])) {
        $nome = $_GET['term'];
    	
    	$json = "";
    	$array = array();
    	$conta = array();
    	$result = mysql_query("SELECT `p`.`pessoa_id` AS id, `c`.`conta_nome_fantasia` AS nome FROM `conta` `c` LEFT JOIN `pessoa` `p` ON `c`.`pessoa_id` = `p`.`pessoa_id` WHERE `c`.`conta_nome_fantasia` LIKE  '%" . $nome . "%' AND `p`.`situacao_id` IN (SELECT situacao_id FROM `situacao` WHERE `situacao_conta` IS TRUE) OR `p`.`situacao_id` IS NULL");

        if (mysql_num_rows($result) > 0) {
    		while ($pessoa = mysql_fetch_assoc($result)) {
    			$name = $pessoa['nome'];
    			$conta = array(
    				"label" => ($name),
    				"value" => ($name),
    				"id" => $pessoa['id']);
    			array_push($array, $conta);
    		}
    	}
    
    	array_push($array, array(
    		"id" => "nova_conta",
    		"label" => "[+] Criar nova conta",
    		"value" => "$nome"));
    
    	$json = json_encode($array);
    
        print $json;
    }
	exit();
?>