<?php
	include ("../../lib/connection.php");

	if (isset($_GET['term'])) {
		$nome = $_GET['term'];

		$json = "";
		$array = array();
		$prod = array();

		$produtos = mysql_query("SELECT * FROM `produto` WHERE `produto_nome` LIKE '%$nome%'");

		if (mysql_num_rows($produtos) > 0) {
			while ($produto = mysql_fetch_assoc($produtos)) {
				$name = $produto['produto_nome'];
				$prod = array(
					"label" => $name . " - produto",
					"value" => $name,
					"id" => $produto['produto_id']);
				array_push($array, $prod);
			}
		}

		$json = json_encode($array);

		print $json;
	}
	exit();
?>