<?php
	include ("../lib/connection.php");

    $id = $_POST['id'];
    $refer = $_POST['ref'];
    $codbarra = $_POST['codb'];
	$nome = $_POST['nome'];
	$codforn = $_POST['codf'];
    $descri = $_POST['comp'];
    $espec = $_POST['espec'];
    $unidade = $_POST['unid'];
    $categoria = $_POST['cat'];
    $ativo = $_POST['ativo'];
    
    $venda = empty($_POST['venda']) ? "0.00" : $_POST['venda'];
    $venda = str_replace(",", ".", $venda);
    
    $ipi = empty($_POST['ipi']) ? "0.00" : $_POST['ipi'];
    $ipi = str_replace(",", ".", $ipi);

    $erro = "Por favor verifique:<br/>";
    
    if(empty($nome)) {
        $erro .= "Campo Nome é obrigat&oacute;rio<br/>";
    }
    if(empty($codforn)) {
        $erro .= "Campo Fornecedor é obrigat&oacute;rio<br/>";
    }
    if(strlen($erro) > 25) {
        echo ("0|$erro");
        exit();
    }

    if (empty($id)) {
		$cat = mysql_query("INSERT INTO `produto` VALUES (NULL, $categoria, '$nome', $venda, $ativo, '$refer', '$codbarra', $ipi, '$descri', '$espec', $codforn, $unidade, CURDATE(), {$_COOKIE['id']})");
        $id = mysql_insert_id();
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']},'Inseriu', 'Produto', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	} else {
		$cat = mysql_query("UPDATE `produto` SET categoria_produto_id = $categoria, produto_nome = '$nome', produto_valor_venda = $venda, produto_ativo = $ativo, produto_referencia = '$refer', produto_cod_barras = '$codbarra', produto_ipi = $ipi, produto_descricao = '$descri', produto_especificacoes = '$espec', pessoa_id = $codforn, unidade_medida_id = $unidade WHERE `produto_id` = $id");
        mysql_query("INSERT INTO `logs` VALUES (NULL, {$_COOKIE['id']}, 'Alterou', 'Produto', '{$_SERVER['REMOTE_ADDR']}', NOW(), $id)");
	}
	if ($cat) {
		echo ("1|Produto gravada com sucesso!");
	} else {
		echo ("0|Problemas ao gravar, tente novamente!");
	}
    exit();
?>