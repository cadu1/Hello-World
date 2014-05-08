<?php
	if (isset($_POST['id'])) {
		include ("../lib/connection.php");

		$id = $_POST['id'];

		$result = mysql_query("DELETE FROM `produto` WHERE produto_id = $id");
		if ($result) {
			echo "1|Produto excluída com sucesso!";
            mysql_query("INSERT INTO `logs` VALUES(NULL, {$_COOKIE['id']}, 'Excluiu', 'Produto', '{$SERVER['REMOTE_ADDR']}', NOW(), $id)");
		} else {
			echo "0|Problemas ao excluir, tente novamente!";
		}
	} else {
		echo "0|Problemas ao excluir, tente novamente!";
	}
	exit();
?>