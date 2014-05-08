<?php
	include ("../../lib/connection.php");

	if (isset($_GET['term'])) {
		$nome = $_GET['term'];

		$json = "";
		$array = array();
		$forn = array();

		$result = mysql_query("SELECT p.pessoa_id AS id, c.contato_nome AS nome1, co.conta_nome_fantasia AS nome2 FROM `pessoa` p LEFT JOIN `contato` c ON p.pessoa_id = c.pessoa_id LEFT JOIN `conta` co ON p.pessoa_id = co.pessoa_id WHERE p.situacao_id = 10 AND c.contato_nome LIKE '%$nome%' OR co.conta_nome_fantasia LIKE '%$nome%'");
		$row = mysql_num_rows($result);

		if ($row > 0) {
			while ($pessoa = mysql_fetch_assoc($result)) {
				$name = (!empty($pessoa['nome1']) ? $pessoa['nome1'] : $pessoa['nome2']);
				$forn = array(
					"label" => ($name),
					"value" => ($name),
					"id" => $pessoa['id']);
				array_push($array, $forn);
			}
		}

		array_push($array, array(
			"id" => "novo_contato",
			"label" => "[+] Criar novo contato",
			"value" => "$nome"));
		array_push($array, array(
			"id" => "nova_conta",
			"label" => "[+] Criar nova conta",
			"value" => "$nome"));

		$json = json_encode($array);

		print $json;
	}
	exit();
?>