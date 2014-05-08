<?php
	include ("../lib/connection.php");

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$sigla = $_POST['sigla'];
    
    if (empty($id)) {
		$cat = mysql_query("INSERT INTO `unidade_medida` VALUES (NULL, '$nome', '$sigla', {$_COOKIE['id']})");
        $id = mysql_insert_id();
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']},'Inseriu', 'Unidade Medida', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	} else {
		$cat = mysql_query("UPDATE `unidade_medida` SET unidade_medida_nome = '$nome', unidade_medida_sigla = '$sigla' WHERE unidade_medida_id = $id");
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']},'Alterou', 'Unidade Medida', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	}
	if ($cat) {
		echo ("1|Unidade gravada com sucesso!");
	} else {
		echo ("0|Problemas ao gravar, tente novamente!");
	}
    exit();
?>