<?php
	if (isset($_POST['id'])) {
		include ("../lib/connection.php");

		$id = $_POST['id'];

		$result = mysql_query("DELETE FROM `unidade_medida` WHERE unidade_medida_id = $id");
        if ($result) {
			echo "1|Unidade excluída com sucesso!";
            mysql_query("INSERT INTO `logs` VALUES(NULL, {$_COOKIE['id']}, 'Excluiu', 'Unidade Medida', '{$SERVER['REMOTE_ADDR']}', NOW(), $id)");
		} else {
			echo "0|Problemas ao excluir, tente novamente!";
		}
	} else {
		echo "0|Problemas ao excluir, tente novamente!";
	}
	exit();
?>