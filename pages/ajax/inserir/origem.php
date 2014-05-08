<?php
	include ("../../lib/connection.php");

	$resp = "";
    
    $nome = $_POST["nome"];

	if (!empty($nome)) {
        $ori = mysql_query("SELECT * FROM `origem` WHERE `nome` = '$nome'");
        $row = @mysql_num_rows($ori);
		if ($row == 0) {
			$ori = mysql_query("INSERT INTO origem (`origem_nome`) VALUES ('$nome')");
			if ($ori) {
				$resp = "1|Gravada com sucesso!";
			} else {
				$resp = "0|Já existe uma origem com este nome!";
			}
		} else {
			$resp = "0|Já existe uma origem com este nome!";
		}
	} else {
		$resp = "0|Já existe uma origem com este nome!";
	}
	echo $resp;
?>