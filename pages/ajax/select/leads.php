<?php
    include("../../lib/connection.php");

    if(isset($_GET['term'])) {
        $nome = $_GET['term'];
    	
    	$json = "";
    	$array = array();
    	$conta = array();
    	$result = mysql_query("SELECT `l`.`lead_id`, `l`.`lead_nome` FROM `lead` `l` JOIN `informacao` `i` ON `l`.`informacao_id` = `i`.`informacao_id` WHERE `l`.`lead_nome` LIKE  '%" . $nome . "%' OR `i`.`informacao_email` LIKE  '%" . $nome . "%' OR `i`.`informacao_telefone` LIKE  '%" . $nome . "%' OR `lead_conta` LIKE  '%" . $nome . "%'");

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
    	$json = json_encode($array);
    
        print $json;
    }
	exit();
?>