<?php
	include ("../lib/connection.php");
	if (isset($_POST["nome"])) {
		$nome = $_POST["nome"];

		mysql_query("INSERT INTO `pessoa` (pessoa_id, situacao_id) VALUES(NULL, 10)");

		$id = mysql_insert_id();

		if ($id > 0) {
			$result = mysql_query("INSERT INTO `contato` (conta_id, pessoa_id, contato_nome) VALUES(NULL, $id, '$nome')");

			if ($result) {
				$id = mysql_insert_id();

				echo "1|Contato gravada com sucesso!|$id";
			} else {
				echo "0|Ocorreu um erro, tente novamente!|";
			}
		} else {
			echo "0|Ocorreu um erro, tente novamente!|";
		}
	} else {
		echo "0|Ocorreu um erro, tente novamente!|";
	}
?>