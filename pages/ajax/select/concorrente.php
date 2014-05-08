<?php
    include("../../lib/connection.php");

    if(isset($_GET['term'])) {
        $nome = $_GET['term'];
    	
    	$json = "";
    	$array = array();
    	$contato = array();
    	$result = mysql_query("SELECT `p`.`pessoa_id` AS id, IFNULL(`c`.`contato_nome`, `co`.`conta_razao_social`) AS nome FROM `pessoa` `p` LEFT JOIN `contato` `c` ON `p`.`pessoa_id` = `c`.`pessoa_id` LEFT JOIN `conta` `co` ON `p`.`pessoa_id` = `co`.`pessoa_id` WHERE `p`.`situacao_id` IN (5,6,7,8,9,10,11,12,13) AND `c`.`contato_nome` LIKE '%" . $term . "%' OR `co`.`conta_razao_social` LIKE '%" . $term . "%'");

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