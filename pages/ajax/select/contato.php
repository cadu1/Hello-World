<?php
    include("../../lib/connection.php");

    if(isset($_GET['term'])) {
        $nome = $_GET['term'];
    	
    	$json = "";
    	$array = array();
    	$contato = array();
    	$result = mysql_query("SELECT `p`.`pessoa_id` AS id, `c`.`contato_nome` AS nome FROM `contato` `c` LEFT JOIN `pessoa` `p` ON `c`.`pessoa_id` = `p`.`pessoa_id` WHERE `c`.`contato_nome` LIKE  '%" . $nome . "%' AND `p`.`situacao_id` IN (SELECT situacao_id FROM `situacao` WHERE `situacao_contato` IS TRUE) OR `p`.`situacao_id` IS NULL");

    	if (mysql_num_rows($result) > 0) {
    		while ($pessoa = mysql_fetch_assoc($result)) {
    			$name = $pessoa['nome'];
    			$contato = array(
    				"label" => ($name),
    				"value" => ($name),
    				"id" => $pessoa['id']);
    			array_push($array, $contato);
    		}
    	}

    	array_push($array, array(
    		"id" => "novo_contato",
    		"label" => "[+] Criar novo contato",
    		"value" => "$nome"));
    
    	$json = json_encode($array);
    
        print $json;
    }
	exit();
?>