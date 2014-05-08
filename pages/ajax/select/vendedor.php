<?php
    include("../../lib/connection.php");

    if(isset($_GET['term'])) {
        $nome = $_GET['term'];
    	
    	$json = "";
    	$array = array();
    	$contato = array();
    	$result = mysql_query("SELECT `p`.`pessoa_id` AS id, `c`.`contato_nome` AS nome FROM `pessoa` `p` LEFT JOIN `contato` `c` ON `p`.`pessoa_id` = `c`.`pessoa_id` WHERE `p`.`situacao_id` = 13 AND `c`.`contato_nome` LIKE '%" . $nome . "%'");

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
    	$json = json_encode($array);
    
        print $json;
    }
	exit();
?>