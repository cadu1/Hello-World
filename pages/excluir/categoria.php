<?php
	if (isset($_POST['id'])) {
		include ("../lib/connection.php");

		$id = $_POST['id'];

		$consult = mysql_query("SELECT * FROM `categoria_produto` WHERE categoria_produto_pai_id = $id");
		$row = mysql_num_rows($consult);

		if ($row > 0) {
			echo "0|Erro! Esta categoria possui filhos!";
		} else {
			$result = mysql_query("DELETE FROM `categoria_produto` WHERE categoria_produto_id = $id");
			if ($result) {
				echo "1|Categoria excluída com sucesso!";
                mysql_query("INSERT INTO `logs` VALUES(NULL, {$_COOKIE['id']}, 'Excluiu', 'Categoria', '{$SERVER['REMOTE_ADDR']}', NOW(), $id)");
			} else {
				echo "0|Problemas ao excluir, tente novamente!";
			}
		}
	} else {
		echo "0|Problemas ao excluir, tente novamente!";
	}
	exit();
?>