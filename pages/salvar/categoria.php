<?php
	include ("../lib/connection.php");

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$pai = ($_POST['pai'] != 0 ? $_POST['pai'] : "NULL");
    $ipi = (empty($_POST['ipi']) ? "0.00" : $_POST['ipi']);
    $ipi = str_replace(",", ".", $ipi);
    
    if (empty($id)) {
		$cat = mysql_query("INSERT INTO `categoria_produto` VALUES (NULL, '$nome', $ipi, $pai, 1)");
        $id = mysql_insert_id();
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']},'Inseriu', 'Produto Categoria', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	} else {
		$cat = mysql_query("UPDATE `categoria_produto` SET categoria_produto_nome = '$nome', categoria_produto_ipi = $ipi, categoria_produto_pai_id = $pai WHERE categoria_produto_id = $id");
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']},'Alterou', 'Produto Categoria', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	}
	if ($cat) {
		echo ("1|Categoria gravada com sucesso!");
	} else {
		echo ("0|Problemas ao gravar, tente novamente!");
	}
?>